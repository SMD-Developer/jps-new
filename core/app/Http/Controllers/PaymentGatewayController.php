<?php

namespace App\Http\Controllers;

use App\Http\Forms\PaymentGatewayForm;
use App\Http\Requests\PaymentMethodFrmRequest;
use App\Invoicer\Repositories\Contracts\PaymentMethodInterface;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentGatewayController extends CrudController
{
    protected string $formClass = PaymentGatewayForm::class;
    protected $formRequest = PaymentMethodFrmRequest::class;
    protected string $heading =  'app.payment_gateways';
    protected string $icon = 'money';
    protected bool $showBtnCreate = false;
    protected bool $settingsMode = true;
    public function __construct(PaymentMethodInterface $paymentMethodInterface){
        parent::__construct();
        $this->repository = $paymentMethodInterface;
        $this->entityClass = PaymentMethod::class;
    }
    protected array $routes = [
        'index' => 'settings.gateways.index',
        'store' => 'settings.gateways.store'
    ];
    public function index(): mixed
    {
        $paypal_details = config('services.paypal');
        $stripe_details = config('services.stripe');
        $paypal = $this->repository->where('name','Paypal')->first();
        $stripe = $this->repository->where('name','Stripe')->first();
        $form = $this->form($this->formClass, [
            'method' => 'POST',
            'url' => route($this->routes['store']),
            'class' => 'needs-validation', 'novalidate',
            'model' => [
                'paypal_id' => $paypal->uuid ?? null,
                'stripe_id' => $stripe->uuid ?? null,
                'paypal_details' => $paypal_details,
                'stripe_details' => $stripe_details
            ]
        ]);
        return view('settings.index', compact('form'));
    }
    public function store(Request $request)
    {
        if(!isset($request->paypal_id)){
            $this->repository->create(array('name' => 'Paypal'));
        }
        if(!isset($request->stripe_id)){
            $this->repository->create(array('name' => 'Stripe'));
        }
        saveConfiguration([
            'PAYPAL_CLIENT_ID' => $request->client_id,
            'PAYPAL_CLIENT_SECRET' => $request->secret_key,
            'PAYPAL_STATUS' => $request->paypal_status,
            'PAYPAL_ACCOUNT' => $request->paypal_account,
            'PAYPAL_MODE' => $request->paypal_mode,
        ]);
        saveConfiguration([
            'STRIPE_SECRET' => $request->stripe_secret,
            'STRIPE_STATUS' => $request->stripe_status,
            'STRIPE_KEY' => $request->stripe_key,
        ]);
        flash()->success(trans('app.record_updated'));
        return redirect()->route($this->routes['index']);
    }
}
