<?php
namespace App\Http\Controllers\ClientArea;
use App\Http\Requests\ClientAreaCheckoutRequest;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\InvoiceSettingInterface as InvoiceSetting;
use App\Invoicer\Repositories\Contracts\SettingInterface as Setting;
use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\PaymentMethodInterface as PaymentMethod;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
class CheckoutController extends Controller{
    protected $invoice,$invoiceSetting,$setting,$payment,$paymentMethod,$gateway,$stripeGateway;
    public function __construct(Invoice $invoice, Setting $setting, InvoiceSetting $invoiceSetting,Payment $payment,PaymentMethod $paymentMethod){
        $this->invoiceSetting = $invoiceSetting;
        $this->payment = $payment;
        $this->paymentMethod = $paymentMethod;
        $this->invoice = $invoice;
        $this->setting   = $setting;
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(config('services.paypal.client_id'));
        $this->gateway->setSecret(config('services.paypal.secret'));
        $this->gateway->setTestMode(config('services.paypal.mode') === 'sandbox'); //set it to 'false' when go live
        $this->stripeGateway = Omnipay::create('Stripe');
        $this->stripeGateway->initialize(['apiKey' => config('services.stripe.secret')]);
    }
    public function getCheckout(ClientAreaCheckoutRequest $request){
        if (auth('user')->user()){
            $invoice_id = $request->invoice_id;
            $invoice = $this->invoice->getById($invoice_id);
            $invoice_totals = $this->invoice->invoiceTotals($invoice_id);
            $selected_method = $request->selected_method;
            if($selected_method === 'paypal' && config('services.paypal.status') == 1){
                try {
                        $response = $this->gateway->purchase(array(
                            'amount' => $invoice_totals['amountDue'],
                            'currency' => $invoice->currency,
                            'returnUrl' => route('getDone'),
                            'cancelUrl' => route('getCancel',$invoice_id),
                            'transactionId' =>$invoice->uuid,
                            'description'=> trans('app.invoice').' '.trans('app.payment')
                        ))->send();
                    if ($response->isRedirect()) {
                        return redirect($response->getRedirectUrl());
                    }

                    if ($response->isSuccessful()) {
                        // payment was successful: update database
                        print_r($response);
                    } else {
                        // payment failed: display message to customer
                        flash()->error($response->getMessage());
                        return redirect()->route('cinvoices.index');
                    }
                } catch(\Exception $e) {
                    dd($e->getMessage());
                    flash()->error($e->getMessage());
                    return redirect()->route('cinvoices.index');
                }
            }else{
                return redirect()->route('stripecheckout',$invoice_id);
            }
        }
        return null;
    }

    public function stripeCheckout($invoice_id){
        $invoice = $this->invoice->getById($invoice_id);
        $invoiceSettings = $this->invoiceSetting->first();
        $invoice->totals = $this->invoice->invoiceTotals($invoice_id);
        $stripe_key = config('services.stripe.key');
        $settings = $this->setting->first();
        return view('clientarea.payment_methods.stripe', compact('invoice','invoiceSettings','settings','stripe_key'));
    }
    public function stripeSuccess(Request $request){
        $invoice = $this->invoice->getById($request->invoice_id);
        if($invoice){
            $response = $this->stripeGateway->purchase([
                'amount' => $request->amount,
                'currency' => $invoice->currency != '' ? $invoice->currency : strtolower(defaultCurrencyCode()),
                'token' => $request->stripeToken,
            ])->send();
            if($response->isSuccessful()){
                $payment_method_model = $this->paymentMethod->model();
                $payment_method = $payment_method_model::where('name','Stripe')->first();
                if(!$payment_method){
                    $payment_method = $payment_method_model::create(['name'=>'Stripe']);
                }
                $payment_data = [
                    'invoice_id' => $request->get('invoice_id'),
                    'payment_date' => date('Y-m-d'),
                    'amount' => $request->get('amount'),
                    'method' => $payment_method->uuid,
                    'notes' => 'Transaction Id : '.$request->get('stripeToken')
                ];
                if($this->payment->create($payment_data)) {
                    $this->invoice->changeStatus($request->get('invoice_id'));
                }
                flash()->success(trans('app.payment_successful'));
                return redirect()->route('cinvoices.show', $request->invoice_id);
            }
        }
        flash()->error(trans('app.payment_failed'));
        return redirect()->route('stripecheckout', $request->invoice_id);
    }
    public function paypalNotify(Request $request){
        $txn_id = $request->txn_id;
        $invoice_id = $request->item_number;
        $payment_method_model = $this->paymentMethod->model();
        $payment_method = $payment_method_model::where('name','Paypal')->first();
        if(!$payment_method){
            $payment_method = $payment_method_model::create(['name'=>'Paypal']);
        }
        $payment_data = [
            'invoice_id' => $invoice_id,
            'payment_date' => date('Y-m-d'),
            'amount' => $request->payment_gross,
            'method' => $payment_method->uuid,
            'notes' => 'Transaction id : '.$txn_id
        ];
        if($this->payment->create($payment_data)) {
            $this->invoice->changeStatus($invoice_id);
        }
    }
    public function getDone(Request $request){
        if ($request->input('paymentId') && $request->input('PayerID')){
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
            if ($response->isSuccessful()){
                // The customer has successfully paid.
                $arr_body = $response->getData();
                $invoice_id = $arr_body['transactions'][0]['invoice_number'];
                $amount = $arr_body['transactions'][0]['amount']['total'];
                $payment_model = $this->payment->model();
                $notes = 'Transaction id : '.$arr_body['id'];
                $payment_record = $payment_model::where('notes',$notes)->where('invoice_id',$invoice_id)->first();
                if(!$payment_record){
                    $payment_method_model = $this->paymentMethod->model();
                    $payment_method = $payment_method_model::where('name','Paypal')->first();
                    if(!$payment_method){
                        $payment_method = $payment_method_model::create(['name'=>'Paypal']);
                    }
                    $payment_data = [
                        'invoice_id' => $invoice_id,
                        'payment_date' => date('Y-m-d'),
                        'amount' => $amount,
                        'method' => $payment_method->uuid,
                        'notes' => $notes
                    ];
                    if($this->payment->create($payment_data)) {
                        $this->invoice->changeStatus($invoice_id);
                    }
                }
                flash()->success(trans('app.payment_successful'));
                return redirect()->route('cinvoices.show', $invoice_id);
            }

            flash()->error(trans('app.payment_failed'));
        } else {
            flash()->error(trans('app.payment_failed'));
        }
        return redirect()->route('cinvoices.index');
    }
    public function getCancel($invoice_id){
        flash()->error(trans('app.payment_cancelled'));
        return redirect()->route('cinvoices.show', $invoice_id);
    }
}
