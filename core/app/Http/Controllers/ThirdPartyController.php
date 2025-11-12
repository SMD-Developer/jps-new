<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ClientRegisterModel;
use App\Models\ThirdPartyPrint;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Client;
use App\Models\ThirdPartyUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PaymentSuccessful;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;




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
        if (!auth('third_party')->check()) {
            return redirect()->route('third.party.login')->with('error', 'Please login first.');
        }

        $amount = 1.00;
        $thirdPartyUser = auth('third_party')->user();
        
        // Store necessary data in session
        session([
            'application_id' => $application->id,
            'payment_amount' => 1.00,
            'payment_type' => 'third_party_reprint',
            'third_party_id' => $thirdPartyUser->id
        ]);
        
        return view('third-party.payment-selection', compact('application', 'amount'));
    }


    public function processPaymentSelection(Request $request)
    {
        if (!auth('third_party')->check()) {
            return redirect()->route('third.party.login')
                ->with('error', 'Session expired. Please login again.');
        }

        $request->validate([
            'payment_mode' => 'required|in:b2c,b2b',
            'selected_bank' => 'required',
            'email' => 'required|email',
            'application_id' => 'required|exists:applications,id'
        ]);

        // Get logged in third party user
        $thirdPartyUser = auth('third_party')->user();
        $applicationId = $request->application_id;


        // Store payment selection in session
        session([
            'payment_mode' => $request->payment_mode,
            'selected_bank' => $request->selected_bank,
            'buyer_email' => $request->email,
            'payment_amount' => 1.00,
            'payment_type' => 'third_party_reprint',
            'application_id' => $applicationId,
            'third_party_id' => $thirdPartyUser->id
        ]);

        // Redirect based on payment mode
        if ($request->payment_mode === 'b2c') {
            return redirect()->route('third.party.pay.details.b2c', [
                'amount' => 1.00,
                'bank' => $request->selected_bank
            ]);
        } else {
            return redirect()->route('third.party.pay.details.b2b', [
                'amount' => 10.00,
                'bank' => $request->selected_bank
            ]);
        }
    }



    public function b2c(Request $request)
    {
        if (!auth('third_party')->check()) {
            return redirect()->route('third.party.login')
                ->with('error', 'Session expired. Please login again.');
        }
        
        $thirdPartyUser = auth('third_party')->user();
        $applicationId = session('application_id');
        $thirdPartyId = session('third_party_id');
        
        if (!$applicationId || !$thirdPartyId) {
            return redirect()->route('third.party.search')
                ->with('error', 'Application not found. Please search again.');
        }
        
        $amount = 1.00; 
        $bankCode = $request->get('bank', session('selected_bank'));
        $testCase = $request->get('testCase', session('test_case', '1.1 - Valid Account'));
        
        $fpx_callbackUrl = route('fpx.callback'); 
        $fpx_returnUrl = route('fpx.return');   
        
        $application = Application::find($applicationId);
        
        if (!$application) {
            return redirect()->route('third.party.search')
                ->with('error', 'Application not found.');
        }
        
        $referenceNo = $application->refference_no;
        
        $bankData = $this->getDynamicBankData($bankCode);
        
        // FPX Parameters
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
        
        // Use authenticated third party user info
        $fpx_buyerEmail = session('buyer_email', $thirdPartyUser->email);
        $fpx_buyerName = $thirdPartyUser->name;
        
        $fpx_buyerBankId = $bankData['bank_code']; 
        $fpx_buyerBankBranch = $bankData['bank_name']; 
        
        $fpx_buyerAccNo = "";
        $fpx_buyerId = "";
        $fpx_makerName = "";
        $fpx_buyerIban = "";
        $fpx_productDesc = "Third Party Document Reprint - RM 10.00";
        $fpx_version = "6.0";
        
        // Create checksum data string
        $data = $fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;

        // Generate checksum
        $priv_key = file_get_contents('/var/www/html/core/public/privatekey.php');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $fpx_checkSum = strtoupper(bin2hex($binary_signature));
        
        $actionUrl = 'https://www.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp';
        
        $receiptNumber = $this->generateReceiptNumber('');
        
        // Store payment data for third party
        $this->storePaymentData([
            'user_id' => null,
            'third_party_id' => $thirdPartyId,
            'payment_type' => 'third_party_reprint',
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
                'third_party_info' => [
                    'id' => $thirdPartyId,
                    'name' => $thirdPartyUser->name,
                    'email' => $thirdPartyUser->email,
                    'id_card_number' => $thirdPartyUser->id_card_number ?? null,
                    'address' => $thirdPartyUser->address ?? null
                ]
            ]),
            'payment_date' => now()->toDateString()
        ]);
        
        // Store transaction details
        $this->storeTransactionDetails([
            'third_party_id' => $thirdPartyId,
            'order_no' => $fpx_sellerOrderNo,
            'amount' => $fpx_txnAmount,
            'bank_code' => $bankCode,
            'test_case' => $testCase,
            'application_id' => $applicationId,
            'bank_id' => $fpx_buyerBankId
        ]);

        
        return view('third-party.payments.b2c-checkout', compact(
            'fpx_msgType', 'fpx_msgToken', 'fpx_sellerTxnTime', 'fpx_sellerExId', 
            'fpx_sellerExOrderNo', 'fpx_sellerOrderNo', 'fpx_sellerId', 
            'fpx_sellerBankCode', 'fpx_txnCurrency', 'fpx_txnAmount', 
            'fpx_buyerEmail', 'fpx_checkSum', 'fpx_buyerName', 'fpx_buyerBankId', 
            'fpx_buyerBankBranch', 'fpx_buyerAccNo', 'fpx_buyerId', 'fpx_makerName', 
            'fpx_buyerIban', 'fpx_productDesc', 'fpx_version', 'actionUrl',
            'fpx_callbackUrl', 'fpx_returnUrl', 'referenceNo'
        ));
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
    
    
    private function storePaymentData($paymentData)
    {
        try {
            $paymentId = DB::table('payments')->insertGetId([
                'uuid' => (string) Str::uuid(),
                'user_id' => $paymentData['user_id'] ?? null,
                'third_party_id' => $paymentData['third_party_id'] ?? null, 
                'application_id' => $paymentData['application_id'] ?? null,
                'payment_type' => $paymentData['payment_type'] ?? 'user', 
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
                'test_case' => $paymentData['test_case'] ?? null, 
                'created_at' => now(),
                'updated_at' => now()
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
        $fpx_sellerExId = "EX00014529";
        $fpx_version = "6.0";

        $data = $fpx_msgToken."|".$fpx_msgType."|".$fpx_sellerExId."|".$fpx_version;
        
        try {
            $priv_key = file_get_contents('/var/www/html/core/public/privatekey.php');
            
            if (!$priv_key) {
                throw new \Exception("Private key file not found or not readable");
            }
            
            $pkeyid = openssl_get_privatekey($priv_key);
            
            if (!$pkeyid) {
                throw new \Exception("Invalid private key format");
            }
            
            openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
            $fpx_checkSum = strtoupper(bin2hex($binary_signature));
            
        } catch (\Exception $e) {
            
            return [
                'success' => false,
                'error' => 'Private key error: ' . $e->getMessage(),
                'error_type' => 'PRIVATE_KEY_ERROR',
                'banks' => [],
                'test_cases' => []
            ];
        }
        
        $url = 'https://www.mepsfpx.com.my/FPXMain/RetrieveBankList';
        
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
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            
            $result = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            $curl_errno = curl_errno($ch);
            
            curl_close($ch);
            
            // Check for CURL errors
            if ($curl_errno) {
                
                throw new \Exception("Connection error: " . $curl_error . " (Code: " . $curl_errno . ")");
            }
            
            // Check HTTP response code
            if ($http_code !== 200) {
                
                throw new \Exception("HTTP Error: " . $http_code);
            }
            
            // Check if response is empty
            if (empty($result)) {
                
                throw new \Exception("Empty response from FPX server");
            }
            
            // Parse the response
            $token = strtok($result, "&");
            while ($token !== false) {
                if (strpos($token, '=') !== false) {
                    list($key1, $value1) = explode("=", $token, 2);
                    $value1 = urldecode($value1);
                    $response_value[$key1] = $value1;
                }
                $token = strtok("&");
            }
            
            // Check if required fields exist
            if (!isset($response_value['fpx_bankList']) || 
                !isset($response_value['fpx_checkSum']) ||
                !isset($response_value['fpx_msgToken'])) {
                
                throw new \Exception("Invalid response structure from FPX. Missing required fields.");
            }
            
            // Verify the signature
            $data = $response_value['fpx_bankList']."|".$response_value['fpx_msgToken']."|".$response_value['fpx_msgType']."|".$response_value['fpx_sellerExId'];
            $val = $this->verifySign_fpx($response_value['fpx_checkSum'], $data);
            
            if (!$val) {
                \Log::warning('FPX Signature Verification Failed', [
                    'checksum' => $response_value['fpx_checkSum']
                ]);
            }
            
            // Process bank list with status from API
            $token = strtok($response_value['fpx_bankList'], ",");
            while ($token !== false) {
                if (strpos($token, '~') !== false) {
                    list($bank_code, $api_status) = explode("~", $token);
                    $api_status = urldecode($api_status);
                    $bank_list[$bank_code] = $api_status;
                }
                $token = strtok(",");
            }
            
            if (empty($bank_list)) {
                \Log::warning('FPX No Banks Found', [
                    'bank_list_string' => $response_value['fpx_bankList']
                ]);
                
                throw new \Exception("No banks found in response");
            }
            
            \Log::info('FPX Banks Retrieved', [
                'bank_count' => count($bank_list),
                'msg_token' => $msgToken
            ]);
            
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
                'banks' => $enhanced_bank_list,
                'test_cases' => [
                    ($msgToken == '01' ? '1.1' : '2.1') => ($msgToken == '01' ? 'B2C Positive Scenario - Valid Account' : 'B2B Positive Scenario - Valid Account'),
                    ($msgToken == '01' ? '1.2' : '2.2') => ($msgToken == '01' ? 'B2C Maximum Scenario - Exceeded Amount' : 'B2B Maximum Scenario - Exceeded Amount'),
                    ($msgToken == '01' ? '1.3' : '2.3') => ($msgToken == '01' ? 'B2C Minimum Scenario - Below Minimum' : 'B2B Minimum Scenario - Below Minimum'),
                    ($msgToken == '01' ? '1.4' : '2.4') => ($msgToken == '01' ? 'B2C Negative Scenario - Insufficient Funds' : 'B2B Negative Scenario - Insufficient Funds'),
                    '3.1' => 'Re-query Scenario - AE message',
                    '4.1' => 'Retrieved Bank List - BE message'
                ]
            ];
            
        } catch(\Exception $e) {
            \Log::error('FPX Bank List Fetch Failed', [
                'error' => $e->getMessage(),
                'msg_token' => $msgToken,
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_type' => 'API_ERROR',
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
        $baseUrl = 'https://www.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp';
    
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
        $path = '/var/www/html/core/public/';

    	$d_ate = date("Y");
    	$fpxcert = array($path."fpxprod_smi_20241219.cer");
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
        $fpx_sellerExId = $paymentRecord->seller_ex_id ?? "EX00014529"; 
        $fpx_sellerExOrderNo = $paymentRecord->seller_order_no;
        $fpx_sellerTxnTime = $paymentRecord->seller_txn_time ?? date('YmdHis', strtotime($paymentRecord->created_at));
        $fpx_sellerOrderNo = $paymentRecord->seller_order_no;
        $fpx_sellerId = $paymentRecord->seller_id ?? "SE00110559"; 
        $fpx_sellerBankCode = "01";
        $fpx_txnCurrency = $paymentRecord->currency ?? "MYR";
        
        // FIXED: Ensure amount format matches exactly
        $fpx_txnAmount = number_format((float)$paymentRecord->amount, 2, '.', '');
        
        // ENSURE these fields are not empty for B2B
        $fpx_buyerEmail = $paymentRecord->buyer_email ?? "";
        $fpx_buyerName = $paymentRecord->buyer_name ?? "";
        
        $fpx_buyerBankId = $paymentRecord->buyer_bank_id ?? ""; 
        $fpx_buyerBankBranch = $paymentRecord->buyer_bank_branch ?? ""; 
        
        $fpx_checkSum = "";
        $fpx_buyerAccNo = "";
        $fpx_buyerId = "";
        $fpx_makerName = "";
        $fpx_buyerIban = "";
        $fpx_productDesc = $paymentRecord->product_desc ?? "Payment";
        $fpx_version = "6.0";
        
        $data = $fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;
        
        $priv_key = file_get_contents('/var/www/html/core/public/privatekey.php');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $fpx_checkSum = strtoupper(bin2hex($binary_signature));
        
        $fields_string = "";
        $response_value = array();
        $ErrorCode = '';
        
        // Set POST variables
        $url = 'https://www.mepsfpx.com.my/FPXMain/sellerNVPTxnStatus.jsp';
        
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
            
            
        } catch(Exception $e) {
            \Log::error('FPX Status Inquiry Failed', [
                'order_no' => $orderNo,
                'error' => $e->getMessage()
            ]);
            $ErrorCode = 'Error: ' . $e->getMessage();
        }
        
        return view('clientarea.payments.status', compact('val', 'fpx_debitAuthCode', 'response_value', 'ErrorCode', 'paymentRecord'));
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


    // route for third party user registration 

    public function register(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'name'             => 'required|string|max:255',
                'email'            => [
                    'required',
                    'email',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        // Check if email already exists in third_party_users table
                        $exists = DB::table('third_party_users')->where('email', $value)->exists();
                        if ($exists) {
                            $fail('This email is already registered.');
                        }
                    },
                ],
                'id_card_number'   => [
                    'string',
                    'max:50',
                    function ($attribute, $value, $fail) {
                        // Check if ID card number already exists
                        $exists = DB::table('third_party_users')->where('id_card_number', $value)->exists();
                        if ($exists) {
                            $fail('This ID card number is already registered.');
                        }
                    },
                ],
                'address'          => 'required|string',
                'password'         => 'required|string|min:8',
                'confirm_password' => 'required|same:password',
                'terms'            => '',
            ], [
                'name.required'             => 'Name is required.',
                'email.required'            => 'Email is required.',
                'email.email'               => 'Please enter a valid email address.',
                'id_card_number.required'   => 'ID card number is required.',
                'address.required'          => 'Address is required.',
                'password.required'         => 'Password is required.',
                'password.min'              => 'Password must be at least 8 characters.',
                'confirm_password.required' => 'Please confirm your password.',
                'confirm_password.same'     => 'Passwords do not match.',
                'terms.required'            => 'You must accept the terms and conditions.',
                'terms.accepted'            => 'You must accept the terms and conditions.',
            ]);

            // If validation fails
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }

            // Use database transaction
            DB::beginTransaction();

            try {
                // Create third party user
                $thirdPartyUser = ThirdPartyUser::create([
                    'name'           => $request->name,
                    'email'          => $request->email,
                    'id_card_number' => $request->id_card_number,
                    'address'        => $request->address,
                    'password'       => Hash::make($request->password),
                    'status'         => 1, 
                ]);

                // Commit the transaction
                DB::commit();

                // Return success response
                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful! You can now login.',
                    'data'    => [
                        'user_id' => $thirdPartyUser->id,
                        'email'   => $thirdPartyUser->email,
                    ]
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
                'error'   => $e->getMessage(), // Remove this in production
            ], 500);
        }
    }

    public function showLoginForm()
    {
        return view('third-party.default');
    }


   


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $credentials = $request->only('email', 'password');

        if (auth('third_party')->attempt($credentials)) {
            $request->session()->regenerate();
            
            // Check if it's an AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => route('third.party.dashboard')
                ]);
            }
            
            // Regular form submission - redirect directly
            return redirect()->route('third.party.dashboard')
                ->with('success', 'Login successful!');
        }

        // Check if it's an AJAX request
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials. Please try again.'
            ], 401);
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid credentials. Please try again.');
    }


    public function dashboard()
    {
        if (!auth('third_party')->check()) {
            return redirect()->route('third.party.login')
                ->with('error', 'Please login first.');
        }

        $user = auth('third_party')->user();
        
        return view('third-party.dashboard', compact('user'));
    }


    public function logout(Request $request)
    {
        try {
            auth('third_party')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('third.party.login')
                ->with('success', 'You have been logged out successfully.');
        } catch (\Exception $e) {
            \Log::error('Third party logout error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Something went wrong while logging out.');
        }
    }


    public function searchFilter(Request $request)
    {
        $title = __("app.search");
        
        $divisions = DB::table('division')
            ->where('status', 1)
            ->orderBy('mukim_code', 'asc')
            ->get();
            
        $districts = DB::table('district')
            ->where('idnegeri', 1)
            ->where('stat', 1)
            ->orderBy('daerah_code', 'asc')
            ->get();
            
        $applicants = ClientRegisterModel::select('client_id', 'userName')->get();
        
        $lotPts = Application::select('id', 'land_lot as lot_number')
            ->whereNotNull('land_lot')
            ->distinct('land_lot')
            ->orderBy('land_lot', 'asc')
            ->get();
            
        // If it's a POST request, redirect to results page with search parameters
        if ($request->isMethod('post')) {
            return redirect()->route('search-results')->withInput();
        }
        
        // For GET request, show the search form
        return view('third-party.search-filter', [
            'title' => $title,
            'divisions' => $divisions,
            'districts' => $districts,
            'applicants' => $applicants,
            'lotPts' => $lotPts,
            'request' => $request
        ]);
    }


    public function searchResults(Request $request)
    {
        $title = __("app.search_results");
        
        $query = Application::query();

        // Build search query
        if ($request->filled('lot_pt_grant')) {
            $query->where('land_lot', 'like', '%' . $request->lot_pt_grant . '%');
        }
        
        if ($request->filled('division')) {
            $query->where('land_state', $request->division);
        }
        
        if ($request->filled('district')) {
            $query->where('land_district', $request->district);
        }
        
        if ($request->filled('applicant_id')) {
            $query->where('user_id', $request->applicant_id);
        }
        
        if ($request->filled('reference_number')) {
            $query->where('refference_no', 'like', '%' . $request->reference_number . '%');
        }
        
        if ($request->filled('application_date')) {
            $query->whereDate('created_at', $request->application_date);
        }

        $query->whereHas('payment', function ($q) {
            $q->where('payment_status', 'completed');
        });
        
        // Get results with pagination
        $applications = $query->with(['applicant', 'division', 'districts', 'payment' => function($q) {
                            // Load ALL payments, but you can order to get completed first
                            $q->orderByRaw("FIELD(payment_status, 'completed') DESC");
                        }])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        
        // Get filter data for display
        $filters = [
            'district' => $request->district,
            'division' => $request->division,
            'applicant_name' => $request->applicant_id ? ClientRegisterModel::find($request->applicant_id)->userName ?? '' : '',
            'lot_number' => $request->lot_pt_grant,
            'reference_number' => $request->reference_number,
            'application_date' => $request->application_date
        ];
        
        // Get districts and divisions for filter display
        $districts = DB::table('district')->get()->keyBy('iddaerah');
        $divisions = DB::table('division')->get()->keyBy('idmukim');
        
        return view('third-party.search-results', [
            'title' => $title,
            'applications' => $applications,
            'filters' => $filters,
            'districts' => $districts,
            'divisions' => $divisions,
            'request' => $request
        ]);
    }





}