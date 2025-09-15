<?php 

namespace App\Http\Controllers\ClientArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Payment;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PayController extends Controller 
{
    /// Summary description for Controller
    ///  ErrorCode  : Description
    ///  00         : Your signature has been verified successfully.  
    ///  06         : No Certificate found 
    ///  07         : One Certificate Found and Expired
    ///  08         : Both Certificates Expired
    ///  09         : Your Data cannot be verified against the Signature.

    // public function b2c(Request $request)
    // {
    //     $amount = $request->get('amount', session('payment_amount', 20.00));
    //     $bankCode = $request->get('bank', session('selected_bank', 'SBI_BANK_A'));
    //     $testCase = $request->get('testCase', session('test_case', '1.1 - Valid Account'));
        
    //      $fpx_callbackUrl = route('fpx.callback'); 
    //      $fpx_returnUrl = route('fpx.return');   
        
    //     $applicationId = session('application_id');
    //     $application = null;
    //     if ($applicationId) {
    //         $application = Application::find($applicationId); 
    //     }
        
    //     $bankData = $this->getDynamicBankData($bankCode);
        
    //     $fpx_msgType = "AR";
    //     $fpx_msgToken = "01";
    //     $fpx_sellerExId = "EX00026203";
    //     $fpx_sellerExOrderNo=date('YmdHis');
    //     $fpx_sellerTxnTime = date('YmdHis');
    //     $fpx_sellerOrderNo=date('YmdHis');
    //     $fpx_sellerId = "SE00101283";
    //     $fpx_sellerBankCode = "01";
    //     $fpx_txnCurrency = "MYR";
    //     $fpx_txnAmount = number_format($amount, 2, '.', '');
        
    //     $fpx_buyerEmail = $application ? ($application->email ?? "test@example.com") : "test@example.com";
    //     $fpx_buyerName = $application ? ($application->applicant ?? "Test User") : "Test User";
        
    //     $fpx_buyerBankId = $bankData['bank_code']; 
    //     $fpx_buyerBankBranch = $bankData['bank_name']; 
        
    //     if ($bankCode === 'SBI_BANK_A') {
    //         $fpx_buyerBankId = 'TEST0021';
    //         $fpx_buyerBankBranch = 'SBI BANK A';
    //     } elseif ($bankCode === 'SBI_BANK_B') {
    //         $fpx_buyerBankId = 'TEST0022';
    //         $fpx_buyerBankBranch = 'SBI BANK B';
    //     }
        
    //     $fpx_buyerAccNo = "";
    //     $fpx_buyerId = "";
    //     $fpx_makerName = "";
    //     $fpx_buyerIban = "";
    //     // $fpx_productDesc = $application ? "Trench Contribution Payment - {$application->refference_no}" : "B2C Payment Test";
    //     $fpx_productDesc="Card";
    //     $fpx_version = "6.0";
        
    //     $data = $fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;
    

    //     $priv_key = file_get_contents('/home/wwwsmddeveloper/public_html/jpsmy/core/public/privatekey.php');
    //     $pkeyid = openssl_get_privatekey($priv_key);
    //     openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
    //     $fpx_checkSum = strtoupper(bin2hex($binary_signature));
        
    //     $actionUrl = 'https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp';
        
    //     $receiptNumber = $this->generateReceiptNumber();
        
    //     $this->storePaymentData([
    //     'application_id' => $applicationId,
    //     'amount' => $fpx_txnAmount,
    //     'currency' => $fpx_txnCurrency,
    //     'method' => 'FPX_B2C',
    //     'test_case' => $testCase,
    //     'bank_code' => $bankCode,
    //     'bank_name' => $fpx_buyerBankBranch,
    //     'buyer_bank_id' => $fpx_buyerBankId,
    //     'buyer_email' => $fpx_buyerEmail,
    //     'buyer_name' => $fpx_buyerName,
    //     'seller_order_no' => $fpx_sellerOrderNo,
    //     'seller_ex_order_no' => $fpx_sellerExOrderNo,
    //     'transaction_id' => null, 
    //     'payment_status' => 'pending',
    //     'payment_gateway' => 'FPX',
    //     'fpx_checksum' => $fpx_checkSum,
    //     'receipt_number' => $receiptNumber,
    //     'gateway_response' => json_encode([
    //         'fpx_data' => $data,
    //         'action_url' => $actionUrl,
    //         'timestamp' => now()
    //     ]),
    //     'payment_date' => now()->toDateString()
    // ]);
        
    //     $this->storeTransactionDetails([
    //         'order_no' => $fpx_sellerOrderNo,
    //         'amount' => $fpx_txnAmount,
    //         'bank_code' => $bankCode,
    //         'test_case' => $testCase,
    //         'application_id' => $applicationId,
    //         'bank_id' => $fpx_buyerBankId
    //     ]);
        
    //     return view('clientarea.payments.index', compact('fpx_msgType', 'fpx_msgToken','$fpx_sellerTxnTime', 'fpx_sellerExId', 'fpx_sellerExOrderNo', 'fpx_sellerTxnTime', 'fpx_sellerOrderNo', 'fpx_sellerId', 'fpx_sellerBankCode', 'fpx_txnCurrency', 'fpx_txnAmount', 'fpx_buyerEmail', 'fpx_checkSum', 'fpx_buyerName', 'fpx_buyerBankId', 'fpx_buyerBankBranch', 'fpx_buyerAccNo', 'fpx_buyerId', 'fpx_makerName', 'fpx_buyerIban', 'fpx_productDesc', 'fpx_version', 'actionUrl','fpx_callbackUrl', 'fpx_returnUrl'));

    // }
    
    
    public function b2c(Request $request)
    {
        // Ensure user is authenticated before processing payment
        if (!auth('user')->check()) {
            Log::warning('Unauthenticated user attempted to make payment');
            return redirect()->route('login')->with('error', 'Please login to proceed with payment');
        }
        
        $currentUserId = auth('user')->id();
        Log::info('Payment initiated by user', [
            'user_id' => $currentUserId,
            'user_email' => auth()->user()->email ?? 'Unknown'
        ]);
        
        $amount = $request->get('amount', session('payment_amount', 20.00));
        $bankCode = $request->get('bank', session('selected_bank', 'SBI_BANK_A'));
        $testCase = $request->get('testCase', session('test_case', '1.1 - Valid Account'));
        
        $fpx_callbackUrl = route('fpx.callback'); 
        $fpx_returnUrl = route('fpx.return');   
        
        $applicationId = session('application_id');
        $application = null;
        $referenceNo = null;
        
        if ($applicationId) {
            $application = Application::find($applicationId); 
            $referenceNo = $application ? $application->refference_no: null;
        }
        
        $bankData = $this->getDynamicBankData($bankCode);
        
        $fpx_msgType = "AR";
        $fpx_msgToken = "01";
        $fpx_sellerExId = "EX00026203";
        $fpx_sellerExOrderNo=date('YmdHis');
        $fpx_sellerTxnTime = date('YmdHis');
        $fpx_sellerOrderNo=date('YmdHis');
        $fpx_sellerId = "SE00101283";
        $fpx_sellerBankCode = "01";
        $fpx_txnCurrency = "MYR";
        $fpx_txnAmount = number_format($amount, 2, '.', '');
        
        // Use authenticated user's info as fallback
        $fpx_buyerEmail = $application ? 
            ($application->email ?? auth()->user()->email) : 
            auth()->user()->email;
        $fpx_buyerName = $application ? 
            ($application->applicant ?? auth()->user()->name) : 
            auth()->user()->name;
        
        $fpx_buyerBankId = $bankData['bank_code']; 
        $fpx_buyerBankBranch = $bankData['bank_name']; 
        
        if ($bankCode === 'SBI_BANK_A') {
            $fpx_buyerBankId = 'TEST0021';
            $fpx_buyerBankBranch = 'SBI BANK A';
        } elseif ($bankCode === 'SBI_BANK_B') {
            $fpx_buyerBankId = 'TEST0022';
            $fpx_buyerBankBranch = 'SBI BANK B';
        }
        
        $fpx_buyerAccNo = "";
        $fpx_buyerId = "";
        $fpx_makerName = "";
        $fpx_buyerIban = "";
        $fpx_productDesc="Card";
        $fpx_version = "6.0";
        
        $data = $fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;
    
        $priv_key = file_get_contents('/home/wwwsmddeveloper/public_html/jpsmy/core/public/privatekey.php');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $fpx_checkSum = strtoupper(bin2hex($binary_signature));
        
        $actionUrl = 'https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp';
        
        $receiptNumber = $this->generateReceiptNumber();
        
        // Store payment with user_id
        $this->storePaymentData([
            'user_id' => $currentUserId, // Current authenticated user
            'application_id' => $applicationId,
            'amount' => $fpx_txnAmount,
            'currency' => $fpx_txnCurrency,
            'method' => 'FPX_B2C',
            'test_case' => $testCase,
            'bank_code' => $bankCode,
            'bank_name' => $fpx_buyerBankBranch,
            'buyer_bank_id' => $fpx_buyerBankId,
            'buyer_email' => $fpx_buyerEmail,
            'buyer_name' => $fpx_buyerName,
            'seller_order_no' => $fpx_sellerOrderNo,
            'seller_ex_order_no' => $fpx_sellerExOrderNo,
            'transaction_id' => null, 
            'payment_status' => 'pending',
            'payment_gateway' => 'FPX',
            'fpx_checksum' => $fpx_checkSum,
            'receipt_number' => $receiptNumber,
            'gateway_response' => json_encode([
                'fpx_data' => $data,
                'action_url' => $actionUrl,
                'timestamp' => now(),
                'user_id' => $currentUserId // Also store in gateway response for reference
            ]),
            'payment_date' => now()->toDateString()
        ]);
        
        // Also store user_id in transaction details if needed
        $this->storeTransactionDetails([
            'user_id' => $currentUserId, // Add this if your method supports it
            'order_no' => $fpx_sellerOrderNo,
            'amount' => $fpx_txnAmount,
            'bank_code' => $bankCode,
            'test_case' => $testCase,
            'application_id' => $applicationId,
            'bank_id' => $fpx_buyerBankId
        ]);
        
        return view('clientarea.payments.index', compact('fpx_msgType', 'fpx_msgToken','fpx_sellerTxnTime', 'fpx_sellerExId', 'fpx_sellerExOrderNo', 'fpx_sellerTxnTime', 'fpx_sellerOrderNo', 'fpx_sellerId', 'fpx_sellerBankCode', 'fpx_txnCurrency', 'fpx_txnAmount', 'fpx_buyerEmail', 'fpx_checkSum', 'fpx_buyerName', 'fpx_buyerBankId', 'fpx_buyerBankBranch', 'fpx_buyerAccNo', 'fpx_buyerId', 'fpx_makerName', 'fpx_buyerIban', 'fpx_productDesc', 'fpx_version', 'actionUrl','fpx_callbackUrl', 'fpx_returnUrl', 'referenceNo'));
    }

    
    
    private function generateReceiptNumber()
    {
        $year = date('y');
        $month = date('m'); 
        $day = date('d');
        $prefix = 'JPSSEL';
        
        // Get the last receipt number regardless of date
        $lastReceipt = DB::table('payments')
            ->whereNotNull('receipt_number')
            ->orderBy('created_at', 'desc')
            ->first();
        
        $sequenceNumber = 1; // Default starting number
        
        if ($lastReceipt && $lastReceipt->receipt_number) {
            // Extract the numeric portion (last 6 digits)
            $lastSequence = (int) substr($lastReceipt->receipt_number, -6);
            $sequenceNumber = $lastSequence + 1;
        }
        
        // Format sequence with leading zeros (6 digits)
        $formattedSequence = str_pad($sequenceNumber, 6, '0', STR_PAD_LEFT);
        
        return "{$year}{$prefix}{$month}{$day}{$formattedSequence}";
    }
    
    
    //   private function storePaymentData($paymentData)
    //     {
            
    //         // Add debug logging BEFORE insert
    //         Log::info('About to insert payment data', [
    //             'payment_status_being_inserted' => $paymentData['payment_status'],
    //             'all_data' => $paymentData
    //         ]);
    //         try {
    //             $paymentId = DB::table('payments')->insertGetId([
    //                 'uuid' => (string) Str::uuid(),
    //                 'application_id' => $paymentData['application_id'] ?? null,
    //                 'payment_date' => now()->toDateString(),
    //                 'amount' => $paymentData['amount'] ?? null,
    //                 'currency' => $paymentData['currency'] ?? 'MYR',
    //                 'method' => $paymentData['method'] ?? null,
    //                 'payment_status' => $paymentData['payment_status'],
    //                 'transaction_id' => $paymentData['transaction_id'] ?? null,
    //                 'seller_order_no' => $paymentData['seller_order_no'] ?? null,
    //                 'seller_ex_order_no' => $paymentData['seller_ex_order_no'] ?? null,
    //                 'bank_code' => $paymentData['bank_code'] ?? null,
    //                 'bank_name' => $paymentData['bank_name'] ?? null,
    //                 'buyer_bank_id' => $paymentData['buyer_bank_id'] ?? null,
    //                 'buyer_email' => $paymentData['buyer_email'] ?? null,
    //                 'buyer_name' => $paymentData['buyer_name'] ?? null,
    //                 'receipt_number'=> $paymentData['receipt_number'] ?? null,
    //                 'payment_gateway' => 'FPX',
    //                 'fpx_checksum' => $paymentData['fpx_checksum'] ?? null,
    //                 'gateway_response' => $paymentData['gateway_response'] ?? null,
    //                 'created_at' => now(),
    //                 'updated_at' => now()
    //             ]);
                
                
    //             // if ($generateReceipt && $paymentData['payment_status'] === 'success') {
    //             //     $insertData['receipt_number'] = $this->generateReceiptNumber();
    //             // }
                
    //             // $paymentId = DB::table('payments')->insertGetId($insertData);
                
    //             Log::info('Payment created with pending status', [
    //                 'payment_id' => $paymentId,
    //                 'order_no' => $paymentData['seller_order_no']
    //             ]);
                
    //             return $paymentId;
                
    //         } catch (\Exception $e) {
    //             Log::error('Failed to store payment data', [
    //                 'error' => $e->getMessage(),
    //                 'data' => $paymentData
    //             ]);
    //             throw $e;
    //         }
    //     }
    
    
    private function storePaymentData($paymentData)
    {
        // Add debug logging BEFORE insert
        Log::info('About to insert payment data', [
            'payment_status_being_inserted' => $paymentData['payment_status'],
            'user_id' => $paymentData['user_id'] ?? 'Not provided',
            'all_data' => $paymentData
        ]);
        
        try {
            $paymentId = DB::table('payments')->insertGetId([
                'uuid' => (string) Str::uuid(),
                'user_id' => $paymentData['user_id'] ?? null, // ADD THIS LINE
                'application_id' => $paymentData['application_id'] ?? null,
                'payment_date' => now()->toDateString(),
                'amount' => $paymentData['amount'] ?? null,
                'currency' => $paymentData['currency'] ?? 'MYR',
                'method' => $paymentData['method'] ?? null,
                'payment_status' => $paymentData['payment_status'],
                'transaction_id' => $paymentData['transaction_id'] ?? null,
                'seller_order_no' => $paymentData['seller_order_no'] ?? null,
                'seller_ex_order_no' => $paymentData['seller_ex_order_no'] ?? null,
                'bank_code' => $paymentData['bank_code'] ?? null,
                'bank_name' => $paymentData['bank_name'] ?? null,
                'buyer_bank_id' => $paymentData['buyer_bank_id'] ?? null,
                'buyer_email' => $paymentData['buyer_email'] ?? null,
                'buyer_name' => $paymentData['buyer_name'] ?? null,
                'receipt_number'=> $paymentData['receipt_number'] ?? null,
                'payment_gateway' => 'FPX',
                'fpx_checksum' => $paymentData['fpx_checksum'] ?? null,
                'gateway_response' => $paymentData['gateway_response'] ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            Log::info('Payment created with pending status', [
                'payment_id' => $paymentId,
                'user_id' => $paymentData['user_id'] ?? 'Not provided',
                'order_no' => $paymentData['seller_order_no']
            ]);
            
            return $paymentId;
            
        } catch (\Exception $e) {
            Log::error('Failed to store payment data', [
                'error' => $e->getMessage(),
                'data' => $paymentData
            ]);
            throw $e;
        }
    }
    
    
    




    // public function bankDetails() 
    // { 
    //     $fpx_msgToken="01";
    //     $fpx_msgType="BE";
    //     $fpx_sellerExId="EX00026203";
    //     $fpx_version="6.0";

    //     $data = $fpx_msgToken."|".$fpx_msgType."|".$fpx_sellerExId."|".$fpx_version;
    //     $priv_key = file_get_contents('/home/wwwsmddeveloper/public_html/jpsmy/core/public/privatekey.php');
    //     $pkeyid = openssl_get_privatekey($priv_key);
    //     openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
    //     $fpx_checkSum = strtoupper(bin2hex( $binary_signature ) );
        
        
        
    //     //extract data from the post

    //     extract($_POST);
    //     $fields_string="";
        
    //     //set POST variables
    //     $url ='https://uat.mepsfpx.com.my/FPXMain/RetrieveBankList';
        
    //     $fields = array(
    //     						'fpx_msgToken' => urlencode($fpx_msgToken),
    //     						'fpx_msgType' => urlencode($fpx_msgType),
    //     						'fpx_sellerExId' => urlencode($fpx_sellerExId),
    //     						'fpx_checkSum' => urlencode($fpx_checkSum),
    //     						'fpx_version' => urlencode($fpx_version)
        						
    //     				);
    //     $response_value=array();
    //     $bank_list=array();
        
    //     try{
    //             //url-ify the data for the POST
    //             foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    //             rtrim($fields_string, '&');
                
    //             //open connection
    //             $ch = curl_init();
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                
    //             //set the url, number of POST vars, POST data
    //             curl_setopt($ch,CURLOPT_URL, $url);
                
    //             curl_setopt($ch,CURLOPT_POST, count($fields));
    //             curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                
    //             // receive server response ...
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             //execute post
    //             $result = curl_exec($ch);
                
    //             //close connection
    //             curl_close($ch);
                
    //             $token = strtok($result, "&");
    //             while ($token !== false)
    //             {
    //             	list($key1,$value1)=explode("=", $token);
    //             	$value1=urldecode($value1);
    //             	$response_value[$key1]=$value1;
    //             	$token = strtok("&");
    //             }
                
    //             //Response Checksum Calculation String
    //             $data=$response_value['fpx_bankList']."|".$response_value['fpx_msgToken']."|".$response_value['fpx_msgType']."|".$response_value['fpx_sellerExId'];
    //             $val=$this->verifySign_fpx($response_value['fpx_checkSum'], $data);
                
    //             // val == 00 verification success
                
    //             $token = strtok($response_value['fpx_bankList'], ",");
    //             while ($token !== false)
    //             {
    //             	list($key1,$value1)=explode("~", $token);
    //             	$value1=urldecode($value1);
    //             	$bank_list[$key1]=$value1;
    //             	$token = strtok(",");
    //             }
                
                
    //               if (!empty($bank_list)) {
    //             // Add test case mapping for B2C scenarios
    //             $enhanced_bank_list = [];
                
    //             foreach ($bank_list as $bank_code => $bank_name) {
    //                 $enhanced_bank_list[] = [
    //                     'bank_code' => $bank_code,
    //                     'bank_name' => $bank_name,
    //                     'status' => 'active',
    //                     'test_scenario' => $this->getTestScenario($bank_code)
    //                 ];
    //             }
                
    //             // Add specific test banks if not already present
    //             if (!isset($bank_list['SBI_BANK_A'])) {
    //                 $enhanced_bank_list[] = [
    //                     'bank_code' => 'SBI_BANK_A',
    //                     'bank_name' => 'SBI Bank A',
    //                     'status' => 'active',
    //                     'test_scenario' => 'valid_account'
    //                 ];
    //             }
                
    //             if (!isset($bank_list['SBI_BANK_B'])) {
    //                 $enhanced_bank_list[] = [
    //                     'bank_code' => 'SBI_BANK_B',
    //                     'bank_name' => 'SBI Bank B',
    //                     'status' => 'active',
    //                     'test_scenario' => 'insufficient_funds'
    //                 ];
    //             }
    //     }
        
        
            
    //       }
    //         catch(Exception $e){
    //         	echo 'Error :', ($e->getMessage());
    //         	// Fallback with test case banks
    //             $enhanced_bank_list = [
    //                 [
    //                     'bank_code' => 'SBI_BANK_A',
    //                     'bank_name' => 'SBI Bank A',
    //                     'status' => 'active',
    //                     'test_scenario' => 'valid_account'
    //                 ],
    //                 [
    //                     'bank_code' => 'SBI_BANK_B',
    //                     'bank_name' => 'SBI Bank B',
    //                     'status' => 'active',
    //                     'test_scenario' => 'insufficient_funds'
    //                 ]
    //             ];
    //         }
            
    //         return response()->json([
    //             'success' => true,
    //             'banks' => $enhanced_bank_list,
    //             'test_cases' => [
    //                 '1.1' => 'Positive Scenario - Valid Account',
    //                 '2.1' => 'Maximum Scenario - Exceeded Amount',
    //                 '2.2' => 'Minimum Scenario - Below Minimum',
    //                 '2.3' => 'Negative Scenario - Insufficient Funds',
    //                 '3.1' => 'Re-query Scenario - AE message',
    //                 '4.1' => 'Retrieved Bank List - BE message'
    //             ],
    //             'validation_rules' => [
    //                 'min_amount' => 1.00,
    //                 'max_amount' => 30000.00,
    //                 'currency' => 'RM'
    //             ]
    //         ]);
            
    //         // return view('clientarea.payments.banklist', compact('bank_list', 'data'));
    // }
    
    public function bankDetails() 
    {
        $enhanced_bank_list = [];
        $all_test_cases = [];

        $b2c_result = $this->fetchBankListWithStatus('01', 'BE');
        if ($b2c_result['success']) {
            $enhanced_bank_list = array_merge($enhanced_bank_list, $b2c_result['banks']);
            $all_test_cases['B2C'] = $b2c_result['test_cases'];
        }
        
        // Fetch B2B banks (msgToken = 02) - ALL BANKS (active + inactive)
        $b2b_result = $this->fetchBankListWithStatus('02', 'BE');
        if ($b2b_result['success']) {
            $enhanced_bank_list = array_merge($enhanced_bank_list, $b2b_result['banks']);
            $all_test_cases['B2B'] = $b2b_result['test_cases'];
        }
    
        
        return response()->json([
            'success' => true,
            'banks' => $enhanced_bank_list, 
            'test_cases' => $all_test_cases,
            'validation_rules' => [
                'min_amount' => 1.00,
                'max_amount' => 30000.00,
                'currency' => 'RM'
            ]
        ]);
    }

    private function fetchBankListWithStatus($msgToken, $msgType)
    {
        $fpx_msgToken = $msgToken;
        $fpx_msgType = $msgType;
        $fpx_sellerExId = "EX00026203";
        $fpx_version = "6.0";
    
        $data = $fpx_msgToken."|".$fpx_msgType."|".$fpx_sellerExId."|".$fpx_version;
        $priv_key = file_get_contents('/home/wwwsmddeveloper/public_html/jpsmy/core/public/privatekey.php');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $fpx_checkSum = strtoupper(bin2hex($binary_signature));
        
        $url = 'https://uat.mepsfpx.com.my/FPXMain/RetrieveBankList';
        
        $fields = array(
            'fpx_msgToken' => urlencode($fpx_msgToken),
            'fpx_msgType' => urlencode($fpx_msgType),
            'fpx_sellerExId' => urlencode($fpx_sellerExId),
            'fpx_checkSum' => urlencode($fpx_checkSum),
            'fpx_version' => urlencode($fpx_version)
        );
        
        $response_value = array();
        $bank_list = array();
        
        try {
            $fields_string = http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $result = curl_exec($ch);
            curl_close($ch);
            
            // Parse the response
            $token = strtok($result, "&");
            while ($token !== false) {
                list($key1, $value1) = explode("=", $token);
                $value1 = urldecode($value1);
                $response_value[$key1] = $value1;
                $token = strtok("&");
            }
            
            // Verify the signature
            $data = $response_value['fpx_bankList']."|".$response_value['fpx_msgToken']."|".$response_value['fpx_msgType']."|".$response_value['fpx_sellerExId'];
            $val = $this->verifySign_fpx($response_value['fpx_checkSum'], $data);
            
            // Process bank list with status from API
            $token = strtok($response_value['fpx_bankList'], ",");
            while ($token !== false) {
                list($bank_code, $api_status) = explode("~", $token);
                $api_status = urldecode($api_status); // This will be "A" or "B"
                $bank_list[$bank_code] = $api_status; 
                $token = strtok(",");
            }
            
            // Format the bank list with proper bank data and status
            $enhanced_bank_list = [];
            foreach ($bank_list as $bank_code => $api_status) {
                $bank_data = $this->getBankData($bank_code, $msgToken);
                
                $enhanced_bank_list[] = [
                    'bank_code' => $bank_code,
                    'bank_name' => $bank_data['bank_name'],
                    'display_name' => $bank_data['display_name'],
                    'status' => ($api_status == 'A') ? 'active' : 'inactive', 
                    'test_scenario' => $this->getTestScenario($bank_code),
                    'type' => ($msgToken == '01') ? 'B2C' : 'B2B'
                ];
            }
            
            return [
                'success' => true,
                'banks' => $enhanced_bank_list, // Return all banks (active + inactive)
                'test_cases' => [
                    ($msgToken == '01' ? '1.1' : '2.1') => ($msgToken == '01' ? 'B2C Positive Scenario - Valid Account' : 'B2B Positive Scenario - Valid Account'),
                    ($msgToken == '01' ? '1.2' : '2.2') => ($msgToken == '01' ? 'B2C Maximum Scenario - Exceeded Amount' : 'B2B Maximum Scenario - Exceeded Amount'),
                    ($msgToken == '01' ? '1.3' : '2.3') => ($msgToken == '01' ? 'B2C Minimum Scenario - Below Minimum' : 'B2B Minimum Scenario - Below Minimum'),
                    ($msgToken == '01' ? '1.4' : '2.4') => ($msgToken == '01' ? 'B2C Negative Scenario - Insufficient Funds' : 'B2B Negative Scenario - Insufficient Funds'),
                    '3.1' => 'Re-query Scenario - AE message',
                    '4.1' => 'Retrieved Bank List - BE message'
                ]
            ];
            
        } catch(Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'banks' => [],
                'test_cases' => []
            ];
        }
    }
    
    


    
    
    
    private function getBankName($bankCode, $msgToken)
    {
        $bankData = $this->getBankData($bankCode, $msgToken);
        return $bankData['bank_name'] ?? $bankCode;
    }
    
    private function getBankDisplayName($bankCode, $msgToken)
    {
        $bankData = $this->getBankData($bankCode, $msgToken);
        return $bankData['display_name'] ?? $bankCode;
    }
    
    private function getBankData($bankCode, $msgToken)
    {
        $b2cBanks = [
            'ABB0234' => [
                'bank_name' => 'Affin Bank Berhad B2C - Test ID',
                'display_name' => 'Affin B2C - Test ID'
            ],
            'ABB0233' => [
                'bank_name' => 'Affin Bank Berhad',
                'display_name' => 'Affin Bank'
            ],
            'ABMB0212' => [
                'bank_name' => 'Alliance Bank Malaysia Berhad',
                'display_name' => 'Alliance Bank (Personal)'
            ],
            'AGRO01' => [
                'bank_name' => 'BANK PERTANIAN MALAYSIA BERHAD (AGROBANK)',
                'display_name' => 'AGRONet'
            ],
            'AMBB0209' => [
                'bank_name' => 'AmBank Malaysia Berhad',
                'display_name' => 'Ambank'
            ],
            'BIMB0340' => [
                'bank_name' => 'Bank Islam Malaysia Berhad',
                'display_name' => 'Bank Islam'
            ],
            'BMMB0341' => [
                'bank_name' => 'Bank Muamalat Malaysia Berhad',
                'display_name' => 'Bank Muamalat'
            ],
            'BKRM0602' => [
                'bank_name' => 'Bank Kerjasama Rakyat Malaysia Berhad',
                'display_name' => 'Bank Rakyat'
            ],
            'BOCM01' => [
                'bank_name' => 'Bank Of China (M) Berhad',
                'display_name' => 'Bank Of China'
            ],
            'BSN0601' => [
                'bank_name' => 'Bank Simpanan Nasional',
                'display_name' => 'BSN'
            ],
            'BCBB0235' => [
                'bank_name' => 'CIMB Bank Berhad',
                'display_name' => 'CIMB Clicks'
            ],
            'CIT0219' => [
                'bank_name' => 'CITI Bank Berhad',
                'display_name' => 'Citibank'
            ],
            'HLB0224' => [
                'bank_name' => 'Hong Leong Bank Berhad',
                'display_name' => 'Hong Leong Bank'
            ],
            'HSBC0223' => [
                'bank_name' => 'HSBC Bank Malaysia Berhad',
                'display_name' => 'HSBC Bank'
            ],
            'KFH0346' => [
                'bank_name' => 'Kuwait Finance House (Malaysia) Berhad',
                'display_name' => 'KFH'
            ],
            'LOAD001' => [
                'bank_name' => 'LOAD001',
                'display_name' => 'LOADOO1'
            ],
            'MBB0228' => [
                'bank_name' => 'Malayan Banking Berhad (M2E)',
                'display_name' => 'Maybank2E'
            ],
            'MB2U0227' => [
                'bank_name' => 'Malayan Banking Berhad (M2U)',
                'display_name' => 'Maybank2U'
            ],
            'OCBC0229' => [
                'bank_name' => 'OCBC Bank Malaysia Berhad',
                'display_name' => 'OCBC Bank'
            ],
            'PBB0233' => [
                'bank_name' => 'Public Bank Berhad',
                'display_name' => 'Public Bank'
            ],
            'RHB0218' => [
                'bank_name' => 'RHB Bank Berhad',
                'display_name' => 'RHB Bank'
            ],
            'TEST0021' => [
                'bank_name' => 'SBI Bank A',
                'display_name' => 'SBI Bank A'
            ],
            'TEST0022' => [
                'bank_name' => 'SBI Bank B',
                'display_name' => 'SBI Bank B'
            ],
            'TEST0023' => [
                'bank_name' => 'SBI Bank C',
                'display_name' => 'SBI Bank C'
            ],
            'SCB0216' => [
                'bank_name' => 'Standard Chartered Bank',
                'display_name' => 'Standard Chartered'
            ],
            'UOB0226' => [
                'bank_name' => 'United Overseas Bank',
                'display_name' => 'UOB Bank'
            ],
            'UOB0229' => [
                'bank_name' => 'United Overseas Bank - B2C Test',
                'display_name' => 'UOB Bank - Test ID'
            ]
        ];
        
        $b2bBanks = [
            'ABB0235' => [
                'bank_name' => 'Affin Bank Berhad B2B',
                'display_name' => 'AFFINMAX'
            ],
            'ABB0232' => [
                'bank_name' => 'Affin Bank Berhad ',
                'display_name' => 'Affin Bank'
            ],
            'ABMB0213' => [
                'bank_name' => 'Alliance Bank Malaysia Berhad',
                'display_name' => 'Alliance Bank (Business)'
            ],
            'AGRO02' => [
                'bank_name' => 'BANK PERTANIAN MALAYSIA BERHAD (AGROBANK)',
                'display_name' => 'AGRONetBIZ'
            ],
            'AMBB0208' => [
                'bank_name' => 'AmBank Malaysia Berhad',
                'display_name' => 'AmBank'
            ],
            'BIMB0340' => [
                'bank_name' => 'Bank Islam Malaysia Berhad',
                'display_name' => 'Bank Islam'
            ],
            'BMMB0342' => [
                'bank_name' => 'Bank Muamalat Malaysia Berhad',
                'display_name' => 'Bank Muamalat'
            ],
            'BNP003' => [
                'bank_name' => 'BNP Paribas Malaysia Berhad',
                'display_name' => 'BNP Paribas'
            ],
            'BCBB0235' => [
                'bank_name' => 'CIMB Bank Berhad',
                'display_name' => 'CIMB Bank'
            ],
            'CIT0218' => [
                'bank_name' => 'CITI Bank Berhad',
                'display_name' => 'Citibank Corporate Banking'
            ],
            'DBB0199' => [
                'bank_name' => 'Deutsche Bank Berhad',
                'display_name' => 'Deutsche Bank'
            ],
            'HLB0224' => [
                'bank_name' => 'Hong Leong Bank Berhad',
                'display_name' => 'Hong Leong Bank'
            ],
            'HSBC0223' => [
                'bank_name' => 'HSBC Bank Malaysia Berhad',
                'display_name' => 'HSBC Bank'
            ],
            'BKRM0602' => [
                'bank_name' => 'Bank Kerjasama Rakyat Malaysia Berhad',
                'display_name' => 'i-bizRAKYAT'
            ],
            'KFH0346' => [
                'bank_name' => 'Kuwait Finance House (Malaysia) Berhad',
                'display_name' => 'KFH'
            ],
            'MBB0228' => [
                'bank_name' => 'Malayan Banking Berhad (M2E)',
                'display_name' => 'Maybank2E'
            ],
            'OCBC0229' => [
                'bank_name' => 'OCBC Bank Malaysia Berhad',
                'display_name' => 'OCBC Bank'
            ],
            'PBB0233' => [
                'bank_name' => 'Public Bank Berhad',
                'display_name' => 'Public Bank PBe'
            ],
            'PBB0234' => [
                'bank_name' => 'Public Bank Enterprise',
                'display_name' => 'Public Bank PB enterprise'
            ],
            'RHB0218' => [
                'bank_name' => 'RHB Bank Berhad',
                'display_name' => 'RHB Bank'
            ],
            'TEST0021' => [
                'bank_name' => 'SBI Bank A',
                'display_name' => 'SBI Bank A'
            ],
            'TEST0022' => [
                'bank_name' => 'SBI Bank B',
                'display_name' => 'SBI Bank B'
            ],
            'TEST0023' => [
                'bank_name' => 'SBI Bank C',
                'display_name' => 'SBI Bank C'
            ],
            'SCB0215' => [
                'bank_name' => 'Standard Chartered Bank',
                'display_name' => 'Standard Chartered'
            ],
            'UOB0228' => [
                'bank_name' => 'United Overseas Bank EKB Regional',
                'display_name' => 'UOB Regional'
            ],
            'HSBC0223' => [
                'bank_name' => 'HSBC Bank Malaysia Berhad',
                'display_name' => 'HSBC Bank'
            ]
        ];
    
        if ($msgToken == '01') { // B2C
            return $b2cBanks[$bankCode] ?? ['bank_name' => $bankCode, 'display_name' => $bankCode];
        } else { // B2B
            return $b2bBanks[$bankCode] ?? ['bank_name' => $bankCode, 'display_name' => $bankCode];
        }
    }

    
    private function getTestScenario($bank_code) 
    {
        $test_scenarios = [
            'SBI_BANK_A' => 'valid_account',
            'SBI_BANK_B' => 'insufficient_funds'
        ];
        
        return $test_scenarios[$bank_code] ?? 'normal';
    }

    
    private function getDynamicBankData($bankCode)
    {
        // Get cached bank details to avoid multiple API calls
        if (!session()->has('cached_bank_details')) {
            $response = $this->bankDetails();
            $data = $response->getData(true);
            session(['cached_bank_details' => $data]);
        }
        
        $bankDetails = session('cached_bank_details');
        $banks = $bankDetails['banks'] ?? [];
        
        // Find the bank in dynamic data
        foreach ($banks as $bank) {
            if ($bank['bank_code'] === $bankCode) {
                return $bank;
            }
        }
        
        // Fallback for unknown banks
        return [
            'bank_code' => $bankCode,
            'bank_name' => 'Unknown Bank',
            'test_scenario' => 'normal'
        ];
    }
    
    private function findBankInDynamicList($bankCode)
    {
        $bankDetailsResponse = $this->getBankDetailsData();
        $banks = $bankDetailsResponse['banks'] ?? [];
        
        foreach ($banks as $bank) {
            if ($bank['bank_code'] === $bankCode) {
                return $bank;
            }
        }
        
        return [
            'bank_code' => $bankCode,
            'bank_name' => 'Unknown Bank',
            'test_scenario' => 'normal'
        ];
    }
    
    private function getBankDetailsData()
    {
        if (!session()->has('cached_bank_details')) {
            $response = $this->bankDetails();
            $data = $response->getData(true);
            session(['cached_bank_details' => $data]);
            return $data;
        }
        
        return session('cached_bank_details');
    }


   private function getActionUrl($testCase, $bankCode)
    {
        $baseUrl = 'https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp';
    
        if (strpos($testCase, '2.1') !== false) {
            return $baseUrl . '?testcase=maximum';
        } elseif (strpos($testCase, '2.2') !== false) {
            return $baseUrl . '?testcase=minimum';
        } elseif (strpos($testCase, '2.3') !== false || $bankCode === 'SBI_BANK_B') {
            return $baseUrl . '?testcase=insufficient_funds';
        } elseif (strpos($testCase, '3.1') !== false) {
            return $baseUrl . '?testcase=ae_message';
        } elseif (strpos($testCase, '1.1') !== false || $bankCode === 'SBI_BANK_A') {
            return $baseUrl . '?testcase=valid_account';
        }
        return $baseUrl;
    }
    
    

    private function storeTransactionDetails($details)
    {
        // Store in session for tracking
        session([
            'transaction_details' => $details,
            'transaction_time' => now(),
            'test_case_log' => [
                'case' => $details['test_case'],
                'amount' => $details['amount'],
                'bank' => $details['bank_code'],
                'timestamp' => now()
            ]
        ]);
        
        // Optional: Store in database for audit trail
        // TransactionLog::create($details);
    }


   public function indirect(Request $request)
    {
        $fpx_buyerBankBranch = $request->input('fpx_buyerBankBranch');
        $fpx_buyerBankId = $request->input('fpx_buyerBankId');
        $fpx_buyerIban = $request->input('fpx_buyerIban');
        $fpx_buyerId = $request->input('fpx_buyerId');
        $fpx_buyerName = $request->input('fpx_buyerName');
        $fpx_creditAuthCode = $request->input('fpx_creditAuthCode');
        $fpx_creditAuthNo = $request->input('fpx_creditAuthNo');
        $fpx_debitAuthCode = $request->input('fpx_debitAuthCode');
        $fpx_debitAuthNo = $request->input('fpx_debitAuthNo');
        $fpx_fpxTxnId = $request->input('fpx_fpxTxnId');
        $fpx_fpxTxnTime = $request->input('fpx_fpxTxnTime');
        $fpx_makerName = $request->input('fpx_makerName');
        $fpx_msgToken = $request->input('fpx_msgToken');
        $fpx_msgType = $request->input('fpx_msgType');
        $fpx_sellerExId = $request->input('fpx_sellerExId');
        $fpx_sellerExOrderNo = $request->input('fpx_sellerExOrderNo');
        $fpx_sellerId = $request->input('fpx_sellerId');
        $fpx_sellerOrderNo = $request->input('fpx_sellerOrderNo');
        $fpx_sellerTxnTime = $request->input('fpx_sellerTxnTime');
        $fpx_txnAmount = $request->input('fpx_txnAmount');
        $fpx_txnCurrency = $request->input('fpx_txnCurrency');
        $fpx_checkSum = $request->input('fpx_checkSum');
        
        $data = $fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_creditAuthCode."|".$fpx_creditAuthNo."|".$fpx_debitAuthCode."|".$fpx_debitAuthNo."|".$fpx_fpxTxnId."|".$fpx_fpxTxnTime."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency;
        $val = $this->verifySign_fpx($fpx_checkSum, $data);
        
        $paymentStatus = '';
        $errorCode = '';
        $statusMessage = '';
        
        // Check if this is B2B transaction (fpx_msgToken = "02")
        $isB2B = ($fpx_msgToken === '02');
        
        Log::info('FPX Payment Response Analysis', [
            'fpx_sellerOrderNo' => $fpx_sellerOrderNo,
            'fpx_debitAuthCode' => $fpx_debitAuthCode,
            'fpx_creditAuthCode' => $fpx_creditAuthCode,
            'fpx_msgToken' => $fpx_msgToken,
            'fpx_msgType' => $fpx_msgType,
            'is_b2b' => $isB2B,
            'fpx_fpxTxnId' => $fpx_fpxTxnId
        ]);
        
        // Handle status based on transaction type (B2B vs B2C)
        if ($fpx_debitAuthCode === '00') {
            $paymentStatus = 'completed';
            $statusMessage = 'Payment completed successfully';
        } elseif ($isB2B && $fpx_debitAuthCode === '99') {
            // For B2B: Code 99 means "Pending Authorization" (as per FPX docs page 24)
            $paymentStatus = 'pending_authorization';
            $statusMessage = 'Payment is pending for authorizer approval';
        } elseif ($fpx_debitAuthCode === '09' || $fpx_debitAuthCode === 'A0' || $fpx_debitAuthCode === 'U7') {
            // Common pending codes for both B2B and B2C
            $paymentStatus = 'pending_authorization';
            $statusMessage = 'Payment is pending for authorizer approval';
        } elseif (!$isB2B && $fpx_debitAuthCode === '99') {
            // For B2C: Code 99 means "Failed"
            $paymentStatus = 'failed';
            $errorCode = $fpx_debitAuthCode;
            $statusMessage = 'Transaction declined by bank';
        } else {
            // All other codes are failures
            $paymentStatus = 'failed';
            $errorCode = $fpx_debitAuthCode;
            $statusMessage = $this->getFPXErrorMessage($fpx_debitAuthCode, $isB2B);
        }
        
        Log::info('Payment Status Determined', [
            'fpx_sellerOrderNo' => $fpx_sellerOrderNo,
            'is_b2b' => $isB2B,
            'fpx_debitAuthCode' => $fpx_debitAuthCode,
            'determined_status' => $paymentStatus,
            'status_message' => $statusMessage
        ]);
        
        try {
            $paymentRecord = DB::table('payments') 
                ->where('seller_order_no', $fpx_sellerOrderNo)
                ->first();
                
            if ($paymentRecord) {
                
                  if (!auth('user')->check() && $paymentRecord->user_id) {
                        $client = Client::where('uuid', $paymentRecord->user_id)->first();
            
                        if ($client) {
                            auth('user')->login($client);
                            Log::info('Client auto-login after payment', [
                                'client_uuid' => $client->uuid,
                                'payment_id' => $paymentRecord->id
                            ]);
                        } else {
                            Log::warning('Stale payment user reference', [
                                'stored_uuid' => $paymentRecord->user_id,
                                'payment_id' => $paymentRecord->id
                            ]);
                        }
                    }
                DB::table('payments')
                    ->where('seller_order_no', $fpx_sellerOrderNo)
                    ->update([
                        'transaction_id' => $fpx_fpxTxnId,
                        'payment_status' => $paymentStatus,
                        'status_message' => $statusMessage,
                        'gateway_response' => json_encode([
                            'fpx_response_data' => $request->all(),
                            'signature_valid' => $val,
                            'msg_type' => $fpx_msgType,
                            'msg_token' => $fpx_msgToken,
                            'is_b2b' => $isB2B,
                            'processed_at' => now()
                        ]),
                        'updated_at' => now()
                    ]);
                    
                    
                    
                session(['fpx_order_no' => $fpx_sellerOrderNo]);
            
                \Log::info('FPX Payment Updated', [
                    'order_no' => $fpx_sellerOrderNo,
                    'transaction_id' => $fpx_fpxTxnId,
                    'status' => $paymentStatus,
                    'amount' => $fpx_txnAmount,
                    'is_b2b' => $isB2B
                ]);
                
            } else {
                \Log::error('FPX Payment Record Not Found', [
                    'order_no' => $fpx_sellerOrderNo,
                    'transaction_id' => $fpx_fpxTxnId
                ]);
            }
            
        } catch (\Exception $e) {
            \Log::error('FPX Payment Update Failed', [
                'order_no' => $fpx_sellerOrderNo,
                'error' => $e->getMessage()
            ]);
        }
        
        return view('clientarea.payments.success', compact('val', 'fpx_debitAuthCode', 'fpx_sellerTxnTime', 'fpx_fpxTxnId', 'fpx_sellerOrderNo', 'fpx_buyerBankId', 'fpx_txnAmount', 'ErrorCode', 'fpx_buyerBankBranch'));
    }
	



    private function getFPXErrorMessage($code, $isB2B = false) 
    {
      
        if ($isB2B) {
            $b2bMessages = [
                '00' => 'Payment completed successfully',
                '99' => 'Pending authorization - Waiting for authorizer approval',
                '09' => 'Pending authorization',
                'A0' => 'Pending authorization',
                'U7' => 'Transaction pending approval from bank authorizer',
                '98' => 'Transaction timeout',
                '97' => 'Invalid signature',
                '96' => 'System error',
                '95' => 'Insufficient funds',
                '48' => 'Exception - Contact bank',
                '2A' => 'Exception - Contact bank',
            ];
            
            return $b2bMessages[$code] ?? "B2B Transaction error (Code: {$code})";
        }
        
        $b2cMessages = [
            '00' => 'Payment completed successfully',
            '99' => 'Transaction declined by bank',
            '98' => 'Transaction timeout',
            '97' => 'Invalid signature',
            '96' => 'System error',
            '95' => 'Insufficient funds',
            '09' => 'Pending authorization',
            'A0' => 'Pending authorization',
            'U7' => 'Transaction pending approval',
            '48' => 'Exception - Contact bank',
            '2A' => 'Exception - Contact bank',
        ];
        
        return $b2cMessages[$code] ?? "Transaction error (Code: {$code})";
    }
	
	public function verifySign_fpx($sign,$toSign) 
    {
        $path = '/home/wwwsmddeveloper/public_html/jpsmy/core/public/';

    	$d_ate = date("Y");
    	$fpxcert = array($path."fpxuat_smi_20241015.cer");
    	$certs = $this->checkCertExpiry($fpxcert);
    	$signdata = $this->hextobin($sign);
    	
        if(count($certs) == 1)
        {
            $pkeyid = openssl_pkey_get_public($certs[0]);
            $ret = openssl_verify($toSign, $signdata, $pkeyid);	// 0
            if($ret != 1) 
            {
                $ErrorCode = "09";
                return $ErrorCode;	  
            }
        }elseif(count($certs) == 2){
            $pkeyid =openssl_pkey_get_public($certs[0]);
            $ret = openssl_verify($toSign, $signdata, $pkeyid);	
            if($ret!=1)
            {
        	    $pkeyid =openssl_pkey_get_public($certs[1]);
           	    $ret = openssl_verify($toSign, $signdata, $pkeyid);	
                if($ret!=1) 
                {
                    $ErrorCode = "09";
                    return $ErrorCode;	  
                }
            }
    	}
    	
        if($ret == 1)
        {
            $ErrorCode = "00";
            return $ErrorCode;	  
        }
    	return $ErrorCode;
    }
    
    public function checkCertExpiry($path)
    {
        $stack = array();
        $t_ime= time();
        $curr_date=date("Ymd",$t_ime);
        for($x=0;$x<2;$x++)
        {
            error_reporting(0);
            $key_id = file_get_contents($path[$x]);
            if($key_id==null)
            {
                $cert_exists++;
                continue;
            }	 
            $certinfo = openssl_x509_parse($key_id);
            $s= $certinfo['validTo_time_t']; 
            $crtexpirydate=date("Ymd",$s-86400);
            if($crtexpirydate > $curr_date)
            {
                if ($x > 0)
                {
                    if($this->certRollOver($path[$x], $path[$x-1])=="true")
                    {  
                        array_push($stack,$key_id);
                        return $stack;
                    }
                }	
                array_push($stack,$key_id);
                return $stack;
            }elseif($crtexpirydate == $curr_date){
                if ($x > 0 && (file_exists($path[$x-1])!=1))  
                {	   
                    if($this->certRollOver($path[$x], $path[$x-1])=="true")
                    {  
                        array_push($stack,$key_id);
                        return $stack;
                    }
                }else if(file_exists($path[$x+1])!=1){
                    array_push($stack,file_get_contents($path[$x]),$key_id);
                    return $stack;
                }
                
                array_push($stack,file_get_contents($path[$x+1]),$key_id);
                return $stack;
    	    }
    	}
    	
        if ($cert_exists == 2){
            $ErrorCode="06";
            return $ErrorCode;
        }else if ($stack.Count == 0 && $cert_exists == 1){
            $ErrorCode="07";  
            return $ErrorCode;
        }else if ($stack.Count == 0 && $cert_exists == 0){
           $ErrorCode="08"; 
           return $ErrorCode;
        }
        return $stack;
    }
    
    public function certRollOver($old_crt,$new_crt)
    { 
        if (file_exists($new_crt)==1)
        {
            rename($new_crt,$new_crt."_".date("YmdHis", time()));
        }
		if ((file_exists($new_crt)!=1) && (file_exists($old_crt)==1))
        {
            rename($old_crt,$new_crt);
        }
		return "true";
    }
    
    public function hextobin($hexstr) 
    { 
    	$n = strlen($hexstr); 
    	$sbin="";   
    	$i=0; 
    	while($i<$n) 
    	{       
    		$a =substr($hexstr,$i,2);           
    		$c = pack("H*",$a); 
    		if ($i==0){$sbin=$c;} 
    		else {$sbin.=$c;} 
    		$i+=2; 
    	} 
    	return $sbin; 
    }
    

    
    
    
    public function status(Request $request) 
    {
        $orderNo = $request->input('order_no') ?? session('fpx_order_no');
        
        if (!$orderNo) {
            return redirect()->back()->with('error', 'Order number not found');
        }
        
        // Get payment record from database
        $paymentRecord = DB::table('payments')
            ->where('seller_order_no', $orderNo)
            ->first();
        
        if (!$paymentRecord) {
            return redirect()->back()->with('error', 'Payment record not found');
        }
        
        // Use dynamic values from database
        $fpx_msgType = "AE";
        
        // Determine message token based on payment type (B2B vs B2C)
        $isB2B = false;
        
        // Method 1: Check the 'method' field for FPX_B2B
        if (isset($paymentRecord->method) && $paymentRecord->method === 'FPX_B2B') {
            $isB2B = true;
        }
        
        $fpx_msgToken = $isB2B ? "02" : "01";
        $fpx_sellerExId = $paymentRecord->seller_ex_id ?? "EX00026203"; 
        $fpx_sellerExOrderNo = $paymentRecord->seller_order_no;
        $fpx_sellerTxnTime = $paymentRecord->seller_txn_time ?? date('YmdHis', strtotime($paymentRecord->created_at));
        $fpx_sellerOrderNo = $paymentRecord->seller_order_no;
        $fpx_sellerId = $paymentRecord->seller_id ?? "SE00101283"; 
        $fpx_sellerBankCode = "01";
        $fpx_txnCurrency = $paymentRecord->currency ?? "MYR";
        
        // FIXED: Ensure amount format matches exactly
        $fpx_txnAmount = number_format((float)$paymentRecord->amount, 2, '.', '');
        
        // ENSURE these fields are not empty for B2B
        $fpx_buyerEmail = $paymentRecord->buyer_email ?? "";
        $fpx_buyerName = $paymentRecord->buyer_name ?? "";
        
        // CRITICAL: For B2B, these fields should have values if available from the original transaction
        $fpx_buyerBankId = $paymentRecord->buyer_bank_id ?? ""; // Should not be empty for B2B
        $fpx_buyerBankBranch = $paymentRecord->buyer_bank_branch ?? ""; // Should not be empty for B2B
        
        $fpx_checkSum = "";
        $fpx_buyerAccNo = "";
        $fpx_buyerId = "";
        $fpx_makerName = "";
        $fpx_buyerIban = "";
        $fpx_productDesc = $paymentRecord->product_desc ?? "Payment";
        $fpx_version = "6.0";
        
        // Log the data being used for debugging
        \Log::info('FPX Status Inquiry Data', [
            'order_no' => $orderNo,
            'method' => $paymentRecord->method ?? 'unknown',
            'current_status' => $paymentRecord->payment_status,
            'is_b2b' => $isB2B,
            'msgToken' => $fpx_msgToken,
            'buyerBankId' => $fpx_buyerBankId,
            'buyerBankBranch' => $fpx_buyerBankBranch,
            'txnAmount' => $fpx_txnAmount,
            'buyerEmail' => $fpx_buyerEmail
        ]);
        
        $data = $fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;
        
        $priv_key = file_get_contents('/home/wwwsmddeveloper/public_html/jpsmy/core/public/privatekey.php');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $fpx_checkSum = strtoupper(bin2hex($binary_signature));
        
        $fields_string = "";
        $response_value = array();
        $ErrorCode = '';
        
        // Set POST variables
        $url = 'https://uat.mepsfpx.com.my/FPXMain/sellerNVPTxnStatus.jsp';
        
        $fields = array(
            'fpx_msgType' => urlencode($fpx_msgType),
            'fpx_msgToken' => urlencode($fpx_msgToken),
            'fpx_sellerExId' => urlencode($fpx_sellerExId),
            'fpx_sellerExOrderNo' => urlencode($fpx_sellerExOrderNo),
            'fpx_sellerTxnTime' => urlencode($fpx_sellerTxnTime),
            'fpx_sellerOrderNo' => urlencode($fpx_sellerOrderNo),
            'fpx_sellerId' => urlencode($fpx_sellerId),
            'fpx_sellerBankCode' => urlencode($fpx_sellerBankCode),
            'fpx_txnCurrency' => urlencode($fpx_txnCurrency),
            'fpx_txnAmount' => urlencode($fpx_txnAmount),
            'fpx_buyerEmail' => urlencode($fpx_buyerEmail),
            'fpx_checkSum' => urlencode($fpx_checkSum),
            'fpx_buyerName' => urlencode($fpx_buyerName),
            'fpx_buyerBankId' => urlencode($fpx_buyerBankId),
            'fpx_buyerBankBranch' => urlencode($fpx_buyerBankBranch),
            'fpx_buyerAccNo' => urlencode($fpx_buyerAccNo),
            'fpx_buyerId' => urlencode($fpx_buyerId),
            'fpx_makerName' => urlencode($fpx_makerName),
            'fpx_buyerIban' => urlencode($fpx_buyerIban),
            'fpx_productDesc' => urlencode($fpx_productDesc),
            'fpx_version' => urlencode($fpx_version)
        );
        
        try {
            // URL-ify the data for the POST
            foreach($fields as $key => $value) { 
                $fields_string .= $key.'='.$value.'&'; 
            }
            rtrim($fields_string, '&');
            
            // Log the request being sent
            \Log::info('FPX Status Request', [
                'url' => $url,
                'fields' => $fields
            ]);
            
            // Open connection
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            
            // Receive server response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Execute post
            $result = curl_exec($ch);
            
            // Log the response
            \Log::info('FPX Status Response', ['response' => $result]);
            
            // Close connection
            curl_close($ch);
            
            $token = strtok($result, "&");
            while ($token !== false) {
                list($key1, $value1) = explode("=", $token);
                $value1 = urldecode($value1);
                $response_value[$key1] = $value1;
                $token = strtok("&");
            }
            
            $fpx_debitAuthCode = $response_value['fpx_debitAuthCode'] ?? '';
            
            // Response Checksum Calculation String
            $data = ($response_value['fpx_buyerBankBranch'] ?? '')."|".($response_value['fpx_buyerBankId'] ?? '')."|".($response_value['fpx_buyerIban'] ?? '')."|".($response_value['fpx_buyerId'] ?? '')."|".($response_value['fpx_buyerName'] ?? '')."|".($response_value['fpx_creditAuthCode'] ?? '')."|".($response_value['fpx_creditAuthNo'] ?? '')."|".$fpx_debitAuthCode."|".($response_value['fpx_debitAuthNo'] ?? '')."|".($response_value['fpx_fpxTxnId'] ?? '')."|".($response_value['fpx_fpxTxnTime'] ?? '')."|".($response_value['fpx_makerName'] ?? '')."|".($response_value['fpx_msgToken'] ?? '')."|".($response_value['fpx_msgType'] ?? '')."|".($response_value['fpx_sellerExId'] ?? '')."|".($response_value['fpx_sellerExOrderNo'] ?? '')."|".($response_value['fpx_sellerId'] ?? '')."|".($response_value['fpx_sellerOrderNo'] ?? '')."|".($response_value['fpx_sellerTxnTime'] ?? '')."|".($response_value['fpx_txnAmount'] ?? '')."|".($response_value['fpx_txnCurrency'] ?? '');
            
            $val = $this->verifySign_fpx($response_value['fpx_checkSum'] ?? '', $data);
            
            // ========== DATABASE UPDATE LOGIC ==========
            // Determine new payment status based on FPX response
            $newPaymentStatus = '';
            $newStatusMessage = '';
            
            if ($fpx_debitAuthCode === '00') {
                $newPaymentStatus = 'completed';
                $newStatusMessage = 'Payment completed successfully';
            } elseif ($isB2B && $fpx_debitAuthCode === '99') {
                // For B2B: Code 99 means "Pending Authorization"
                $newPaymentStatus = 'pending_authorization';
                $newStatusMessage = 'Payment is pending for authorizer approval';
            } elseif ($fpx_debitAuthCode === '09' || $fpx_debitAuthCode === 'A0' || $fpx_debitAuthCode === 'U7') {
                $newPaymentStatus = 'pending_authorization';
                $newStatusMessage = 'Payment is pending for authorizer approval';
            } elseif (!$isB2B && $fpx_debitAuthCode === '99') {
                // For B2C: Code 99 means "Failed"
                $newPaymentStatus = 'failed';
                $newStatusMessage = 'Transaction declined by bank';
            } else {
                $newPaymentStatus = 'failed';
                $newStatusMessage = $this->getFPXErrorMessage($fpx_debitAuthCode, $isB2B);
            }
            
            // Check if status has changed
            $statusChanged = ($paymentRecord->payment_status !== $newPaymentStatus);
            
            Log::info('FPX Status Check Result', [
                'order_no' => $orderNo,
                'old_status' => $paymentRecord->payment_status,
                'new_status' => $newPaymentStatus,
                'debit_auth_code' => $fpx_debitAuthCode,
                'is_b2b' => $isB2B,
                'status_changed' => $statusChanged,
                'fpx_txn_id' => $response_value['fpx_fpxTxnId'] ?? 'N/A'
            ]);
            
            // UPDATE DATABASE if status changed or if we got new transaction details
            // if ($statusChanged || !empty($response_value['fpx_fpxTxnId'])) {
            //     try {
            //         $updateData = [
            //             'payment_status' => $newPaymentStatus,
            //             'status_message' => $newStatusMessage,
            //             'updated_at' => now()
            //         ];
                    
            //         // Add transaction ID if we got one
            //         if (!empty($response_value['fpx_fpxTxnId'])) {
            //             $updateData['transaction_id'] = $response_value['fpx_fpxTxnId'];
            //         }
                    
            //         // Update gateway response with latest status inquiry
            //         $updateData['gateway_response'] = json_encode([
            //             'latest_status_inquiry' => $response_value,
            //             'signature_valid' => $val,
            //             'status_checked_at' => now(),
            //             'previous_response' => $paymentRecord->gateway_response ? json_decode($paymentRecord->gateway_response, true) : null
            //         ]);
                    
            //         DB::table('payments')
            //             ->where('seller_order_no', $orderNo)
            //             ->update($updateData);
                    
            //         Log::info('Payment Status Updated in Database', [
            //             'order_no' => $orderNo,
            //             'updated_to' => $newPaymentStatus,
            //             'transaction_id' => $response_value['fpx_fpxTxnId'] ?? 'N/A'
            //         ]);
                    
                    
            //          // Send email if payment is completed and status changed
            //         if ($newPaymentStatus === 'completed' && $statusChanged) {
            //             $this->sendPaymentSuccessEmail($paymentRecord, $response_value);
            //         }
                    
            //         // Refresh payment record for view
            //         $paymentRecord = DB::table('payments')
            //             ->where('seller_order_no', $orderNo)
            //             ->first();
                        
            //     } catch (\Exception $e) {
            //         Log::error('Failed to update payment status', [
            //             'order_no' => $orderNo,
            //             'error' => $e->getMessage()
            //         ]);
            //     }
            // }
            
            // UPDATE DATABASE if status changed or if we got new transaction details
            if ($statusChanged || !empty($response_value['fpx_fpxTxnId'])) {
                try {
                    $updateData = [
                        'payment_status' => $newPaymentStatus,
                        'status_message' => $newStatusMessage,
                        'updated_at' => now()
                    ];
                    
                    // Add transaction ID if we got one
                    if (!empty($response_value['fpx_fpxTxnId'])) {
                        $updateData['transaction_id'] = $response_value['fpx_fpxTxnId'];
                    }
                    
                    // Generate receipt number for B2B transactions when completed
                    if ($isB2B && $newPaymentStatus === 'completed' && $statusChanged) {
                        // Check if receipt number is not already generated
                        if (empty($paymentRecord->receipt_number)) {
                            $receiptNumber = $this->generateReceiptNumber();
                            $updateData['receipt_number'] = $receiptNumber;
                            
                            Log::info('B2B Receipt Number Generated in Status Check', [
                                'order_no' => $orderNo,
                                'receipt_number' => $receiptNumber,
                                'transaction_id' => $response_value['fpx_fpxTxnId'] ?? 'N/A',
                                'old_status' => $paymentRecord->payment_status,
                                'new_status' => $newPaymentStatus
                            ]);
                        }
                    }
                    
                    // Update gateway response with latest status inquiry
                    $updateData['gateway_response'] = json_encode([
                        'latest_status_inquiry' => $response_value,
                        'signature_valid' => $val,
                        'status_checked_at' => now(),
                        'previous_response' => $paymentRecord->gateway_response ? json_decode($paymentRecord->gateway_response, true) : null
                    ]);
                    
                    DB::table('payments')
                        ->where('seller_order_no', $orderNo)
                        ->update($updateData);
                    
                    Log::info('Payment Status Updated in Database', [
                        'order_no' => $orderNo,
                        'updated_to' => $newPaymentStatus,
                        'transaction_id' => $response_value['fpx_fpxTxnId'] ?? 'N/A',
                        'receipt_generated' => isset($updateData['receipt_number']) ? $updateData['receipt_number'] : 'No receipt generated'
                    ]);
                    
                    // Send email if payment is completed and status changed
                    if ($newPaymentStatus === 'completed' && $statusChanged) {
                        $this->sendPaymentSuccessEmail($paymentRecord, $response_value);
                    }
                    
                    // Refresh payment record for view
                    $paymentRecord = DB::table('payments')
                        ->where('seller_order_no', $orderNo)
                        ->first();
                        
                } catch (\Exception $e) {
                    Log::error('Failed to update payment status', [
                        'order_no' => $orderNo,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Log the verification result
            \Log::info('FPX Status Verification', [
                'signature_valid' => $val,
                'debitAuthCode' => $fpx_debitAuthCode,
                'response' => $response_value
            ]);
            
        } catch(Exception $e) {
            \Log::error('FPX Status Inquiry Failed', [
                'order_no' => $orderNo,
                'error' => $e->getMessage()
            ]);
            $ErrorCode = 'Error: ' . $e->getMessage();
        }
        
        return view('clientarea.payments.status', compact('val', 'fpx_debitAuthCode', 'response_value', 'ErrorCode', 'paymentRecord'));
    }
    
    

    
    
       /**
     * Send payment success email to user
     */
    private function sendPaymentSuccessEmail($paymentRecord, $fpxResponse)
    {
        try {
            // Get user email
            $userEmail = $paymentRecord->buyer_email;
            
            if (!$userEmail || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                Log::warning('Cannot send payment email - invalid email', [
                    'order_no' => $paymentRecord->seller_order_no,
                    'email' => $userEmail
                ]);
                return;
            }
            
            // Prepare email data
            $emailData = [
                'buyer_name' => $paymentRecord->buyer_name ?? 'Dear Customer',
                'transaction_id' => $fpxResponse['fpx_fpxTxnId'] ?? $paymentRecord->transaction_id,
                'seller_order_no' => $paymentRecord->seller_order_no,
                'amount' => 'RM ' . number_format($paymentRecord->amount, 2),
                'currency' => $paymentRecord->currency ?? 'MYR',
                'bank_name' => $paymentRecord->bank_name ?? 'N/A',
                'payment_date' => $fpxResponse['fpx_fpxTxnTime'] ?? date('Y-m-d H:i:s'),
                'payment_method' => $paymentRecord->method === 'FPX_B2B' ? 'FPX B2B Corporate Payment' : 'FPX B2C Payment',
                'application_id' => $paymentRecord->application_id
            ];
            
            // Get application details if available
            $application = null;
            if ($paymentRecord->application_id) {
                $application = DB::table('applications')
                    ->where('id', $paymentRecord->application_id)
                    ->first();
                
                if ($application) {
                    $emailData['application_ref'] = $application->reference_no ?? '';
                    // $emailData['service_type'] = $application->service_type ?? '';
                }
            }
            
            Log::info('Sending payment success email', [
                'order_no' => $paymentRecord->seller_order_no,
                'email' => $userEmail,
                'transaction_id' => $emailData['transaction_id']
            ]);
            
            // Send email using Laravel Mail
            Mail::send('emails.payment-success', $emailData, function($message) use ($userEmail, $emailData) {
                $message->to($userEmail)
                        ->subject('Payment Confirmation - Order #' . $emailData['seller_order_no'])
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            // Log successful email send
            Log::info('Payment success email sent successfully', [
                'order_no' => $paymentRecord->seller_order_no,
                'email' => $userEmail,
                'transaction_id' => $emailData['transaction_id']
            ]);
            
            // Update payment record to mark email as sent
            // DB::table('payments')
            //     ->where('seller_order_no', $paymentRecord->seller_order_no)
            //     ->update([
            //         'email_sent' => true,
            //         'email_sent_at' => now(),
            //         'updated_at' => now()
            //     ]);
                
        } catch (\Exception $e) {
            Log::error('Failed to send payment success email', [
                'order_no' => $paymentRecord->seller_order_no,
                'email' => $userEmail ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    

    
   
    
    public function direct(Request $request)
	{
	    $fpx_buyerBankBranch = $request->input('fpx_buyerBankBranch');
        $fpx_buyerBankId = $request->input('fpx_buyerBankId');
        $fpx_buyerIban = $request->input('fpx_buyerIban');
        $fpx_buyerId = $request->input('fpx_buyerId');
        $fpx_buyerName = $request->input('fpx_buyerName');
        $fpx_creditAuthCode = $request->input('fpx_creditAuthCode');
        $fpx_creditAuthNo = $request->input('fpx_creditAuthNo');
        $fpx_debitAuthCode = $request->input('fpx_debitAuthCode');
        $fpx_debitAuthNo = $request->input('fpx_debitAuthNo');
        $fpx_fpxTxnId = $request->input('fpx_fpxTxnId');
        $fpx_fpxTxnTime = $request->input('fpx_fpxTxnTime');
        $fpx_makerName = $request->input('fpx_makerName');
        $fpx_msgToken = $request->input('fpx_msgToken');
        $fpx_msgType = $request->input('fpx_msgType');
        $fpx_sellerExId = $request->input('fpx_sellerExId');
        $fpx_sellerExOrderNo = $request->input('fpx_sellerExOrderNo');
        $fpx_sellerId = $request->input('fpx_sellerId');
        $fpx_sellerOrderNo = $request->input('fpx_sellerOrderNo');
        $fpx_sellerTxnTime = $request->input('fpx_sellerTxnTime');
        $fpx_txnAmount = $request->input('fpx_txnAmount');
        $fpx_txnCurrency = $request->input('fpx_txnCurrency');
        $fpx_checkSum = $request->input('fpx_checkSum');
        
        $data = $fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_creditAuthCode."|".$fpx_creditAuthNo."|".$fpx_debitAuthCode."|".$fpx_debitAuthNo."|".$fpx_fpxTxnId."|".$fpx_fpxTxnTime."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency;
        $val = $this->verifySign_fpx($fpx_checkSum, $data);
        
	    return "OK";
	}
	
// 	public function b2b()
// 	{
// 	    $fpx_msgType="AR";
//         $fpx_msgToken="02";
//         $fpx_sellerExId="EX00026203";
//         $fpx_sellerExOrderNo=date('YmdHis');
//         $fpx_sellerTxnTime=date('YmdHis');
//         $fpx_sellerOrderNo=date('YmdHis');
//         $fpx_sellerId="SE00101283";
//         $fpx_sellerBankCode="01";
//         $fpx_txnCurrency="MYR";
//         $fpx_txnAmount="30.00";
//         $fpx_buyerEmail="bhawesh.smd@gmail.com";
//         $fpx_checkSum="";
//         $fpx_buyerName="Bhawesh Bhaskar";
//         $fpx_buyerBankId="TEST0021";
//         $fpx_buyerBankBranch="SBI BANK A";
//         $fpx_buyerAccNo="";
//         $fpx_buyerId="";
//         $fpx_makerName="";
//         $fpx_buyerIban="";
//         $fpx_productDesc="Card";
//         $fpx_version="6.0";
        
        // $data = $fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;
        // $priv_key = file_get_contents('/home/wwwsmddeveloper/public_html/jpsmy/core/public/privatekey.php');
        // $pkeyid = openssl_get_privatekey($priv_key);
        // openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        // $fpx_checkSum = strtoupper(bin2hex( $binary_signature ) );
        
//         $actionUrl = 'https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp';

//         return view('clientarea.payments.b2b', compact('fpx_msgType', 'fpx_msgToken', 'fpx_sellerExId', 'fpx_sellerExOrderNo', 'fpx_sellerTxnTime', 'fpx_sellerOrderNo', 'fpx_sellerId', 'fpx_sellerBankCode', 'fpx_txnCurrency', 'fpx_txnAmount', 'fpx_buyerEmail', 'fpx_checkSum', 'fpx_buyerName', 'fpx_buyerBankId', 'fpx_buyerBankBranch', 'fpx_buyerAccNo', 'fpx_buyerId', 'fpx_makerName', 'fpx_buyerIban', 'fpx_productDesc', 'fpx_version', 'actionUrl'));
// 	}


    public function b2b(Request $request)
    {
        
        if (!auth('user')->check()) {
            Log::warning('Unauthenticated user attempted to make payment');
            return redirect()->route('login')->with('error', 'Please login to proceed with payment');
        }

        $currentUserId = auth('user')->id();
        $amount = $request->get('amount', session('payment_amount', 30.00));
        $bankCode = $request->get('bank', session('selected_bank', 'SBI_BANK_A'));
        $testCase = $request->get('testCase', session('test_case', '1.1 - Valid Account'));
        
        $fpx_callbackUrl = route('fpx.callback'); 
        $fpx_returnUrl = route('fpx.return');   
        
        $applicationId = session('application_id');
        $application = null;
        $referenceNo = null;
        
        if ($applicationId) {
            $application = Application::find($applicationId); 
             $referenceNo = $application ? $application->refference_no : null;
        }
        
        $bankData = $this->getDynamicBankData($bankCode);
        
        $fpx_msgType = "AR";
        $fpx_msgToken = "02"; 
        $fpx_sellerExId = "EX00026203";
        $fpx_sellerExOrderNo = date('YmdHis');
        $fpx_sellerTxnTime = date('YmdHis');
        $fpx_sellerOrderNo = date('YmdHis');
        $fpx_sellerId = "SE00101283";
        $fpx_sellerBankCode = "01";
        $fpx_txnCurrency = "MYR";
        $fpx_txnAmount = number_format($amount, 2, '.', '');
        
        $fpx_buyerEmail = $application ? ($application->email ?? "test@example.com") : "test@example.com";
        $fpx_buyerName = $application ? ($application->applicant ?? "Test Corporate User") : "Test Corporate User";
        
        $fpx_buyerBankId = $bankData['bank_code']; 
        $fpx_buyerBankBranch = $bankData['bank_name']; 
    
        
        $fpx_buyerAccNo = "";
        $fpx_buyerId = "";
        $fpx_makerName = "";
        $fpx_buyerIban = "";
        // $fpx_productDesc = $application ? "Corporate Payment - {$application->refference_no}" : "B2B Corporate Payment";
        $fpx_productDesc="Card";
        $fpx_version = "6.0";
        
        $data = $fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;

        $priv_key = file_get_contents('/home/wwwsmddeveloper/public_html/jpsmy/core/public/privatekey.php');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $fpx_checkSum = strtoupper(bin2hex( $binary_signature ) );
        
        $actionUrl = 'https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp';
        
        // Store payment data with B2B specific details
        $this->storePaymentData([
            'user_id' => $currentUserId,
            'application_id' => $applicationId,
            'amount' => $fpx_txnAmount,
            'currency' => $fpx_txnCurrency,
            'method' => 'FPX_B2B',
            'test_case' => $testCase,
            'bank_code' => $bankCode,
            'bank_name' => $fpx_buyerBankBranch,
            'buyer_bank_id' => $fpx_buyerBankId,
            'buyer_email' => $fpx_buyerEmail,
            'buyer_name' => $fpx_buyerName,
            'seller_order_no' => $fpx_sellerOrderNo,
            'seller_ex_order_no' => $fpx_sellerExOrderNo,
            'transaction_id' => $fpx_sellerOrderNo, 
            'payment_status' => 'pending',
            'payment_gateway' => 'FPX',
            'fpx_checksum' => $fpx_checkSum,
            'gateway_response' => json_encode([
                'fpx_data' => $data,
                'action_url' => $actionUrl,
                'payment_type' => 'B2B',
                'user_id' => $currentUserId,
                'timestamp' => now()
            ]),
            'payment_date' => now()->toDateString(),
            'admin_notes' => "B2B Corporate Payment - Test Case: {$testCase}"
        ]);
        
        // Store transaction details
        $this->storeTransactionDetails([
            'order_no' => $fpx_sellerOrderNo,
            'amount' => $fpx_txnAmount,
            'bank_code' => $bankCode,
            'test_case' => $testCase,
            'application_id' => $applicationId,
            'bank_id' => $fpx_buyerBankId,
            'payment_type' => 'B2B'
        ]);
        
        return view('clientarea.payments.b2b', compact(
            'fpx_msgType', 'fpx_msgToken', 'fpx_sellerExId', 
            'fpx_sellerExOrderNo', 'fpx_sellerTxnTime', 
            'fpx_sellerOrderNo', 'fpx_sellerId', 'fpx_sellerBankCode', 
            'fpx_txnCurrency', 'fpx_txnAmount', 'fpx_buyerEmail', 
            'fpx_checkSum', 'fpx_buyerName', 'fpx_buyerBankId', 
            'fpx_buyerBankBranch', 'fpx_buyerAccNo', 'fpx_buyerId', 
            'fpx_makerName', 'fpx_buyerIban', 'fpx_productDesc', 
            'fpx_version', 'actionUrl', 'fpx_callbackUrl', 'fpx_returnUrl','referenceNo'
        ));
    }

	
	public function paymentSelection($applicationId, Request $request)
    {
        $application = Application::find($applicationId);
        
        if (!$application) {
            return redirect()->back()->with('error', 'Application not found');
        }
        
         $isReprint = $request->get('type') === 'reprint';
    
        // if ($isReprint) {
        //     // For reprint, set amount to RM 10.00
        //     $applicationData->final_amount = 10.00;
        //     $applicationData->payment_type = 'reprint';
        //     $applicationData->original_application_id = $application; 
        // }
        
        // // Store application data in session
        // session(['application_id' => $applicationId, 'payment_amount' => $application->final_amount]);
        if ($isReprint) {
        $application->final_amount = 10.00;
        $application->payment_type = 'reprint';
        $application->original_application_id = $applicationId; 
        
        // If you want to save these changes to database, uncomment the next line:
        // $application->save();
        
        // Store reprint-specific data in session
        session([
            'application_id' => $applicationId, 
            'payment_amount' => 10.00,
            'payment_type' => 'reprint'
        ]);
    } else {
        // Store original application data in session
        session([
            'application_id' => $applicationId, 
            'payment_amount' => $application->final_amount
        ]);
    }

        
        return view('clientarea.payments.selection', compact('application'));
    }

    public function processPaymentSelection(Request $request)
    {
        $request->validate([
            'payment_mode' => 'required|in:b2c,b2b',
            'selected_bank' => 'required_if:payment_mode,b2c',
            'email' => 'required|email'
        ]);
        
        // Store payment selection in session
        session([
            'payment_mode' => $request->payment_mode,
            'selected_bank' => $request->selected_bank,
            'buyer_email' => $request->email
        ]);
        
        // Redirect based on payment mode
        if ($request->payment_mode === 'b2c') {
            return redirect()->route('pay.details.b2c', [
                'amount' => session('payment_amount'),
                'bank' => $request->selected_bank
            ]);
        } else {
            return redirect()->route('pay.details.b2b');
        }
    }


//   public function paymentSelection($applicationId, Request $request)
// {
//     $application = Application::find($applicationId);
    
//     if (!$application) {
//         return redirect()->back()->with('error', 'Application not found');
//     }
    
//     $isReprint = $request->get('type') === 'reprint';

//     if ($isReprint) {
//         $application->final_amount = 10.00;
//         $application->payment_type = 'reprint';
//         $application->original_application_id = $applicationId; 
        
//         // Store reprint-specific data in session
//         session([
//             'application_id' => $applicationId, 
//             'payment_amount' => 10.00,
//             'payment_type' => 'reprint'
//         ]);
//     } else {
//         // Store original application data in session
//         session([
//             'application_id' => $applicationId, 
//             'payment_amount' => $application->final_amount,
//             'payment_type' => 'original'
//         ]);
//     }
    
//     return view('clientarea.payments.selection', compact('application'));
// }

// public function processPaymentSelection(Request $request)
// {
//     $request->validate([
//         'payment_mode' => 'required|in:b2c,b2b',
//         'selected_bank' => 'required_if:payment_mode,b2c',
//         'email' => 'required|email'
//     ]);
    
//     // Get payment data from request and session
//     $paymentType = session('payment_type', 'original');
//     $applicationId = session('application_id');
//     $paymentMode = $request->input('payment_mode');
//     $selectedBank = $request->input('selected_bank');
//     $email = $request->input('email');
//     $amount = session('payment_amount');
    
//     // **SERVER-SIDE LIMIT VALIDATION**
//     $limitValidation = $this->validatePaymentLimits($amount, $paymentMode, $selectedBank);
    
//     if (!$limitValidation['isValid']) {
//         // Generate unsuccessful receipt directly
//         return $this->generateUnsuccessfulReceipt($request, $limitValidation, $amount, $paymentMode);
//     }
    
//     // If validation passes, store payment selection in session and proceed
//     session([
//         'payment_mode' => $paymentMode,
//         'selected_bank' => $selectedBank,
//         'buyer_email' => $email
//     ]);
    
//     // Redirect based on payment mode
//     if ($paymentMode === 'b2c') {
//         return redirect()->route('pay.details.b2c', [
//             'amount' => $amount,
//             'bank' => $selectedBank
//         ]);
//     } else {
//         return redirect()->route('pay.details.b2b');
//     }
// }

// private function validatePaymentLimits($amount, $paymentMode, $bankCode)
// {
//     $validation = ['isValid' => true, 'reason' => '', 'testCase' => ''];
    
//     if ($paymentMode === 'b2c') {
//         if ($amount > 30000) {
//             $validation = [
//                 'isValid' => false,
//                 'reason' => 'Maximum Transaction Limit Exceeded! (Maximum: RM30000.00)',
//                 'testCase' => '2.1 - Maximum Scenario'
//             ];
//         } elseif ($amount < 1.00) {
//             $validation = [
//                 'isValid' => false,
//                 'reason' => 'Transaction Amount is Lower Than Minimum Limit! (Minimum: RM1.00)',
//                 'testCase' => '2.2 - Minimum Scenario'
//             ];
//         } elseif ($bankCode === 'SBI_BANK_B') {
//             $validation = [
//                 'isValid' => false,
//                 'reason' => 'Insufficient funds in account',
//                 'testCase' => '2.3 - Negative Scenario'
//             ];
//         }
//     } elseif ($paymentMode === 'b2b') {
//         if ($amount > 1000000) {
//             $validation = [
//                 'isValid' => false,
//                 'reason' => 'Maximum Transaction Limit Exceeded! (Maximum: RM1000000.00)',
//                 'testCase' => '2.1 - Maximum Scenario'
//             ];
//         } elseif ($amount < 2.00) {
//             $validation = [
//                 'isValid' => false,
//                 'reason' => 'Transaction Amount is Lower Than Minimum Limit! (Minimum: RM2.00)',
//                 'testCase' => '2.2 - Minimum Scenario'
//             ];
//         } elseif ($bankCode === 'SBI_BANK_B') {
//             $validation = [
//                 'isValid' => false,
//                 'reason' => 'Insufficient funds in account',
//                 'testCase' => '2.3 - Negative Scenario'
//             ];
//         }
//     }
    
//     return $validation;
// }
    
    
// private function generateUnsuccessfulReceipt($request, $limitValidation, $amount, $paymentMode)
// {
//     $receiptNumber = $this->generateReceiptNumber();
//     $orderNo = date('YmdHis');
    
//     // Store unsuccessful payment record
//     $this->storePaymentData([
//         'user_id' => auth('user')->id(),
//         'application_id' => session('application_id'),
//         'amount' => number_format($amount, 2, '.', ''),
//         'currency' => 'MYR',
//         'method' => 'FPX_' . strtoupper($paymentMode),
//         'test_case' => $limitValidation['testCase'],
//         'bank_code' => $request->input('selected_bank'),
//         'buyer_email' => $request->input('email'),
//         'seller_order_no' => $orderNo,
//         'transaction_id' => null,
//         'payment_status' => 'failed',
//         'status_message' => $limitValidation['reason'],
//         'payment_gateway' => 'FPX',
//         'receipt_number' => $receiptNumber,
//         'payment_date' => now()->toDateString()
//     ]);
    
//     // Return unsuccessful receipt view
//     return view('clientarea.payments.unsuccessful-receipt', [
//         'status' => 'UNSUCCESSFUL',
//         'unsuccessful_reason' => $limitValidation['reason'],
//         'transaction_amount' => $amount,
//         'fpx_sellerOrderNo' => $orderNo,
//         'fpx_buyerBankBranch' => $this->getBankName($request->input('selected_bank'), $paymentMode), // Added second parameter
//         'receipt_number' => $receiptNumber,
//         'payment_date' => now()->format('d/m/Y H:i:s'),
//         'test_case' => $limitValidation['testCase']
//     ]);
// }

}
