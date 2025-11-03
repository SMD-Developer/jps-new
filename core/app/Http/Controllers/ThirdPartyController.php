<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ThirdPartyPrint;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PaymentSuccessful;

class ThirdPartyController extends Controller
{
    public function storeThirdPartyInfo(Request $request)
    {
        try {
            $validated = $request->validate([
                'application_id' => 'required|exists:applications,id',
                'name' => 'required|string|max:255',
                'id_number' => 'required|string|max:50',
                'address' => 'required|string',
                'email' => 'required|email|max:255'
            ]);

            $thirdParty = \App\Models\ThirdPartyPrint::create($validated);

            session([
                'third_party_data' => [
                    'id' => $thirdParty->id,
                    'application_id' => $validated['application_id'],
                    'name' => $validated['name'],
                    'id_number' => $validated['id_number'],
                    'address' => $validated['address'],
                    'email' => $validated['email']
                ],
                'payment_amount' => 1.00,
                'payment_type' => 'third_party_print'
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error storing third party info: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function paymentSelection(Application $application)
    {
        $amount = 10.00;
        
        $thirdPartyData = session('third_party_data');
        if (!$thirdPartyData || $thirdPartyData['application_id'] != $application->id) {
            return redirect()->route('applications.search')->with('error', 'Please provide third party information first.');
        }

        session(['application_id' => $application->id]);
        
        return view('third-party.payment-selection', compact('application', 'amount'));
    }


    public function processPaymentSelection(Request $request)
    {
        $request->validate([
            'payment_mode' => 'required|in:b2c,b2b',
            'selected_bank' => 'required_if:payment_mode,b2c',
            'email' => 'required|email'
        ]);

        // Get third party data from session
        $thirdPartyData = session('third_party_data');
        $applicationId = session('application_id');
        
        if (!$thirdPartyData || !$applicationId) {
            return redirect()->route('applications.search')->with('error', 'Session expired. Please start over.');
        }

        // Update third party email if different
        if ($thirdPartyData['email'] !== $request->email) {
            ThirdPartyPrint::where('id', $thirdPartyData['id'])->update([
                'email' => $request->email
            ]);
            
            // Update session
            session(['third_party_data.email' => $request->email]);
        }

        // Store payment selection in session
        session([
            'payment_mode' => $request->payment_mode,
            'selected_bank' => $request->selected_bank,
            'buyer_email' => $request->email
        ]);

        // Redirect based on payment mode
        if ($request->payment_mode === 'b2c') {
            return redirect()->route('third.party.pay.details.b2c');
        } else {
            return redirect()->route('third.party.pay.details.b2b');
        }
    }



    public function b2c(Request $request)
    {
        // Get data from session
        $thirdPartyData = session('third_party_data');
        $applicationId = session('application_id');
        $amount = session('payment_amount', 10.00);
        $bankCode = session('selected_bank', 'TEST0021');
        
        if (!$thirdPartyData || !$applicationId) {
            return redirect()->route('applications.search')->with('error', 'Session expired. Please start over.');
        }

        $application = Application::find($applicationId);
        if (!$application) {
            return redirect()->route('applications.search')->with('error', 'Application not found.');
        }

        $referenceNo = $application->refference_no;
        
        // Use existing PayController to get bank data
        $payController = app('App\Http\Controllers\ClientArea\PayController');
        $bankData = $payController->getDynamicBankData($bankCode);
        
        // FPX parameters
        $fpx_msgType = "AR";
        $fpx_msgToken = "01";
        $fpx_sellerExId = "EX00014529";
        $fpx_sellerExOrderNo = date('YmdHis') . substr(microtime(false), 2, 6) . strtoupper(substr(uniqid(), -4));
        $fpx_sellerTxnTime = date('YmdHis');
        $fpx_sellerOrderNo = date('YmdHis') . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        $fpx_sellerId = "SE00110559";
        $fpx_sellerBankCode = "01";
        $fpx_txnCurrency = "MYR";
        $fpx_txnAmount = number_format($amount, 2, '.', '');
        
        // Use third party data
        $fpx_buyerEmail = $thirdPartyData['email'];
        $fpx_buyerName = $thirdPartyData['name'];
        $fpx_buyerBankId = $bankData['bank_code']; 
        $fpx_buyerBankBranch = $bankData['bank_name']; 
        
        $fpx_buyerAccNo = "";
        $fpx_buyerId = "";
        $fpx_makerName = "";
        $fpx_buyerIban = "";
        $fpx_productDesc = "Third Party Document Print";
        $fpx_version = "6.0";
        
        $data = $fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;

        // Generate signature
        $priv_key = file_get_contents('/var/www/html/core/public/privatekey.php');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $fpx_checkSum = strtoupper(bin2hex($binary_signature));
        
        $actionUrl = 'https://www.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp';
        $fpx_callbackUrl = route('third.party.fpx.callback'); 
        $fpx_returnUrl = route('third.party.fpx.return');
        
        $receiptNumber = $this->generateReceiptNumber();
        
        // Store payment with third_party_id (Option 1)
        $paymentId = DB::table('payments')->insertGetId([
            'uuid' => (string) Str::uuid(),
            'user_id' => null, 
            'third_party_id' => $thirdPartyData['id'], 
            'application_id' => $applicationId,
            'payment_date' => now()->toDateString(),
            'amount' => $fpx_txnAmount,
            'currency' => $fpx_txnCurrency,
            'method' => 'FPX_B2C',
            'payment_status' => 'pending',
            'seller_order_no' => $fpx_sellerOrderNo,
            'seller_ex_order_no' => $fpx_sellerExOrderNo,
            'bank_code' => $bankCode,
            'bank_name' => $fpx_buyerBankBranch,
            'buyer_bank_id' => $fpx_buyerBankId,
            'buyer_email' => $fpx_buyerEmail,
            'buyer_name' => $fpx_buyerName,
            'receipt_number' => $receiptNumber,
            'payment_gateway' => 'FPX',
            'fpx_checksum' => $fpx_checkSum,
            'gateway_response' => json_encode([
                'fpx_data' => $data,
                'action_url' => $actionUrl,
                'timestamp' => now(),
                'payment_type' => 'third_party_print'
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Store transaction in session for tracking
        session([
            'current_payment_id' => $paymentId,
            'seller_order_no' => $fpx_sellerOrderNo
        ]);
        
        return view('third-party.payments.b2c', compact(
            'fpx_msgType', 'fpx_msgToken', 'fpx_sellerExId', 'fpx_sellerExOrderNo',
            'fpx_sellerTxnTime', 'fpx_sellerOrderNo', 'fpx_sellerId', 'fpx_sellerBankCode',
            'fpx_txnCurrency', 'fpx_txnAmount', 'fpx_buyerEmail', 'fpx_checkSum',
            'fpx_buyerName', 'fpx_buyerBankId', 'fpx_buyerBankBranch', 'fpx_buyerAccNo',
            'fpx_buyerId', 'fpx_makerName', 'fpx_buyerIban', 'fpx_productDesc', 'fpx_version',
            'actionUrl', 'fpx_callbackUrl', 'fpx_returnUrl', 'referenceNo'
        ));
    }


    public function b2b(Request $request)
    {
        $thirdPartyData = session('third_party_data');
        $applicationId = session('application_id');
        $amount = session('payment_amount', 10.00);
        
        if (!$thirdPartyData || !$applicationId) {
            return redirect()->route('applications.search')->with('error', 'Session expired. Please start over.');
        }

        $application = Application::find($applicationId);
        $referenceNo = $application ? $application->refference_no : null;
        
        $bankCode = session('selected_bank', 'TEST0021');
        $payController = app('App\Http\Controllers\ClientArea\PayController');
        $bankData = $payController->getDynamicBankData($bankCode);
        
        // B2B FPX parameters
        $fpx_msgType = "AR";
        $fpx_msgToken = "02";
        $fpx_sellerExId = "EX00014529";
        $uniqueOrderNo = date('YmdHis') . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        $fpx_sellerExOrderNo = $uniqueOrderNo;
        $fpx_sellerTxnTime = date('YmdHis');
        $fpx_sellerOrderNo = $uniqueOrderNo;
        $fpx_sellerId = "SE00110559";
        $fpx_sellerBankCode = "01";
        $fpx_txnCurrency = "MYR";
        $fpx_txnAmount = number_format($amount, 2, '.', '');
        
        $fpx_buyerEmail = $thirdPartyData['email'];
        $fpx_buyerName = $thirdPartyData['name'];
        $fpx_buyerBankId = $bankData['bank_code'];
        $fpx_buyerBankBranch = "";
        
        $fpx_buyerAccNo = "";
        $fpx_buyerId = "";
        $fpx_makerName = "";
        $fpx_buyerIban = "";
        $fpx_productDesc = "Third Party Document Print";
        $fpx_version = "7.0";
        
        $data = $fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;

        $priv_key = file_get_contents('/var/www/html/core/public/privatekey.php');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $fpx_checkSum = strtoupper(bin2hex($binary_signature));
        
        $actionUrl = 'https://www.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp';
        $fpx_callbackUrl = route('third.party.fpx.callback');
        $fpx_returnUrl = route('third.party.fpx.return');
        
        $receiptNumber = $this->generateReceiptNumber();
        
        // Store B2B payment with third_party_id
        $paymentId = DB::table('payments')->insertGetId([
            'uuid' => (string) Str::uuid(),
            'user_id' => null, 
            'third_party_id' => $thirdPartyData['id'], 
            'application_id' => $applicationId,
            'payment_date' => now()->toDateString(),
            'amount' => $fpx_txnAmount,
            'currency' => $fpx_txnCurrency,
            'method' => 'FPX_B2B',
            'payment_status' => 'pending',
            'seller_order_no' => $fpx_sellerOrderNo,
            'seller_ex_order_no' => $fpx_sellerExOrderNo,
            'bank_code' => $bankCode,
            'bank_name' => $fpx_buyerBankBranch,
            'buyer_bank_id' => $fpx_buyerBankId,
            'buyer_email' => $fpx_buyerEmail,
            'buyer_name' => $fpx_buyerName,
            'receipt_number' => $receiptNumber,
            'payment_gateway' => 'FPX',
            'fpx_checksum' => $fpx_checkSum,
            'gateway_response' => json_encode([
                'fpx_data' => $data,
                'action_url' => $actionUrl,
                'payment_type' => 'third_party_print',
                'timestamp' => now()
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        session([
            'current_payment_id' => $paymentId,
            'seller_order_no' => $fpx_sellerOrderNo
        ]);
        
        return view('third-party.payments.b2b', compact(
            'fpx_msgType', 'fpx_msgToken', 'fpx_sellerExId', 'fpx_sellerExOrderNo',
            'fpx_sellerTxnTime', 'fpx_sellerOrderNo', 'fpx_sellerId', 'fpx_sellerBankCode',
            'fpx_txnCurrency', 'fpx_txnAmount', 'fpx_buyerEmail', 'fpx_checkSum',
            'fpx_buyerName', 'fpx_buyerBankId', 'fpx_buyerBankBranch', 'fpx_buyerAccNo',
            'fpx_buyerId', 'fpx_makerName', 'fpx_buyerIban', 'fpx_productDesc', 'fpx_version',
            'actionUrl', 'fpx_callbackUrl', 'fpx_returnUrl', 'referenceNo'
        ));
    }


    private function generateReceiptNumber()
    {
        $year = date('y');
        $month = date('m'); 
        $day = date('d');
        $prefix = 'JPSSEL';
        
        $lastReceipt = DB::table('payments')
            ->whereNotNull('receipt_number')
            ->orderBy('created_at', 'desc')
            ->first();
        
        $sequenceNumber = 1;
        
        if ($lastReceipt && $lastReceipt->receipt_number) {
            $lastSequence = (int) substr($lastReceipt->receipt_number, -6);
            $sequenceNumber = $lastSequence + 1;
        }
        
        $formattedSequence = str_pad($sequenceNumber, 6, '0', STR_PAD_LEFT);
        
        return "{$year}{$prefix}{$month}{$day}{$formattedSequence}";
    }


    public function printReceipt(Application $application, Transaction $transaction)
    {
        // Verify transaction is successful and belongs to this application
        if ($transaction->status !== 'successful') {
            abort(404);
        }

        // Update print count
        $thirdPartyPrint = ThirdPartyPrint::where('application_id', $application->id)->first();
        if ($thirdPartyPrint) {
            $thirdPartyPrint->increment('print_count');
            $thirdPartyPrint->update(['last_printed_at' => now()]);
        }

        return view('third-party.receipt', compact('application', 'transaction'));
    }

    private function initiateFpxPayment($transaction)
    {
        // Use your existing FPX integration from PayController
        // You might want to extract this logic to a service class
        // to avoid code duplication
        
        return app('App\Http\Controllers\ClientArea\PayController')
            ->initiateFpxPayment($transaction);
    }
}