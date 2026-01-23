<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Application;
use App\Models\Payment;
use App\Models\ReceiptRequest;
use App\Models\User;
use App\Models\ThirdPartyUser;
use App\Notifications\NewReceiptRequestSubmitted;

class CheckFPXPaymentStatus extends Command
{
    protected $signature = 'fpx:check-status';
    protected $description = 'Check FPX payment status for pending B2B transactions';

    public function handle()
    {
        $this->info('Starting FPX payment status check...');
        
        $pendingPayments = DB::table('payments')
            ->where('payment_status', 'pending_authorization')
            ->where('method', 'FPX_B2B')
            ->where('payment_type', 'third_party') 
            ->where('created_at', '>=', now()->subHours(4))
            ->get();
        
        if ($pendingPayments->isEmpty()) {
            $this->info('No pending third party B2B payments found.');
            return 0;
        }
        
        $this->info("Found {$pendingPayments->count()} pending third party B2B payment(s) to check.");
        
        foreach ($pendingPayments as $payment) {
            $this->checkPaymentStatus($payment);
        }
        
        $this->info('FPX third party B2B payment status check completed.');
        return 0;
    }
    
    private function checkPaymentStatus($paymentRecord)
    {
        try {
            $this->line("Checking order: {$paymentRecord->seller_order_no}");
            
            $originalRequest = null;
            if (!empty($paymentRecord->gateway_response)) {
                $gatewayData = json_decode($paymentRecord->gateway_response, true);
                $originalRequest = $gatewayData['fpx_response_data'] 
                                ?? $gatewayData['latest_status_inquiry'] 
                                ?? $gatewayData['fpx_request_params']  
                                ?? null;
            }
            
            $fpx_sellerExOrderNo = $paymentRecord->seller_ex_order_no ?? $paymentRecord->seller_order_no;
            $fpx_sellerOrderNo = $paymentRecord->seller_order_no;
            $fpx_sellerTxnTime = $paymentRecord->seller_txn_time ?? date('YmdHis', strtotime($paymentRecord->created_at));
            
            if ($originalRequest) {
                if (!empty($originalRequest['fpx_sellerExOrderNo'])) {
                    if ($originalRequest['fpx_sellerExOrderNo'] !== $fpx_sellerExOrderNo) {
                        $this->warn("⚠ Order number mismatch!");
                        $this->line("  DB seller_ex_order_no: {$fpx_sellerExOrderNo}");
                        $this->line("  Gateway response: {$originalRequest['fpx_sellerExOrderNo']}");
                        $this->line("  Using gateway response value");
                    }
                    $fpx_sellerExOrderNo = $originalRequest['fpx_sellerExOrderNo'];
                }
                
                if (!empty($originalRequest['fpx_sellerOrderNo'])) {
                    if ($originalRequest['fpx_sellerOrderNo'] !== $fpx_sellerOrderNo) {
                        $this->warn("⚠ Seller order number mismatch!");
                        $this->line("  DB seller_order_no: {$fpx_sellerOrderNo}");
                        $this->line("  Gateway response: {$originalRequest['fpx_sellerOrderNo']}");
                    }
                    $fpx_sellerOrderNo = $originalRequest['fpx_sellerOrderNo'];
                }
                
                if (!empty($originalRequest['fpx_sellerTxnTime'])) {
                    $fpx_sellerTxnTime = $originalRequest['fpx_sellerTxnTime'];
                }
            }
            
            $this->line("Query params: OrderNo={$fpx_sellerOrderNo}, ExOrderNo={$fpx_sellerExOrderNo}, TxnTime={$fpx_sellerTxnTime}");

            $fpx_msgType = "AE";
            $fpx_msgToken = "02"; 
            $fpx_sellerExId = $paymentRecord->seller_ex_id ?? "EX00014529";
            $fpx_sellerId = $paymentRecord->seller_id ?? "SE00110559";
            $fpx_sellerBankCode = "01";
            $fpx_txnCurrency = $paymentRecord->currency ?? "MYR";
            $fpx_txnAmount = number_format((float)$paymentRecord->amount, 2, '.', '');
            
            $fpx_buyerEmail = $paymentRecord->buyer_email ?? "";
            $fpx_buyerName = $paymentRecord->buyer_name ?? "";
            $fpx_buyerBankId = $paymentRecord->buyer_bank_id ?? "";
            $fpx_buyerBankBranch = $paymentRecord->buyer_bank_branch ?? "";
            
            if ($originalRequest) {
                if (!empty($originalRequest['fpx_buyerEmail'])) {
                    $fpx_buyerEmail = $originalRequest['fpx_buyerEmail'];
                }
                if (!empty($originalRequest['fpx_buyerName'])) {
                    $fpx_buyerName = $originalRequest['fpx_buyerName'];
                }
                if (!empty($originalRequest['fpx_buyerBankId'])) {
                    $fpx_buyerBankId = $originalRequest['fpx_buyerBankId'];
                }
                if (!empty($originalRequest['fpx_buyerBankBranch'])) {
                    $fpx_buyerBankBranch = $originalRequest['fpx_buyerBankBranch'];
                }
            }
            
            $fpx_checkSum = "";
            $fpx_buyerAccNo = "";
            $fpx_buyerId = "";
            $fpx_makerName = "";
            $fpx_buyerIban = "";
            $fpx_productDesc = $paymentRecord->product_desc ?? "Payment";
            $fpx_version = "6.0";
            
            // Generate checksum
            $data = $fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;
            
            $priv_key = file_get_contents('/var/www/html/core/public/privatekey.php');
            $pkeyid = openssl_get_privatekey($priv_key);
            openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
            $fpx_checkSum = strtoupper(bin2hex($binary_signature));
            
            // Prepare POST fields
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
            
            $fields_string = "";
            foreach($fields as $key => $value) { 
                $fields_string .= $key.'='.$value.'&'; 
            }
            $fields_string = rtrim($fields_string, '&');
            
            // Make API call
            $url = 'https://www.mepsfpx.com.my/FPXMain/sellerNVPTxnStatus.jsp';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            
            $result = curl_exec($ch);
            $curl_error = curl_error($ch);
            curl_close($ch);
            
            if ($curl_error) {
                throw new \Exception("CURL Error: " . $curl_error);
            }
            
            // Parse response
            $response_value = array();
            $token = strtok($result, "&");
            while ($token !== false) {
                list($key1, $value1) = explode("=", $token);
                $value1 = urldecode($value1);
                $response_value[$key1] = $value1;
                $token = strtok("&");
            }
            
            $fpx_debitAuthCode = trim((string)($response_value['fpx_debitAuthCode'] ?? ''));
            
            $newPaymentStatus = '';
            $newStatusMessage = '';
            
            if ($fpx_debitAuthCode === '00') {
                $newPaymentStatus = 'completed';
                $newStatusMessage = 'Payment completed successfully';
                $this->info("✓ Order {$paymentRecord->seller_order_no}: Payment APPROVED");
            } elseif ($fpx_debitAuthCode === '99') {
                $newPaymentStatus = 'pending_authorization';
                $newStatusMessage = 'Payment is pending for authorizer approval';
                $this->line("⏳ Order {$paymentRecord->seller_order_no}: Still pending");
            } elseif ($fpx_debitAuthCode === '76') {
                if (!empty($originalRequest['fpx_fpxTxnId'])) {
                    $this->warn("⚠ Order {$paymentRecord->seller_order_no}: Code 76 but transaction ID exists ({$originalRequest['fpx_fpxTxnId']})");
                    $this->warn("   This might be a completed transaction. Manual verification recommended.");
                    return;
                }
                
                $this->warn("⚠ Order {$paymentRecord->seller_order_no}: Transaction not found in FPX (Code 76)");
                return;
                
            } elseif (in_array($fpx_debitAuthCode, ['09', 'A0', 'U7'])) {
                $newPaymentStatus = 'pending_authorization';
                $newStatusMessage = 'Payment is pending for authorizer approval';
                $this->line("⏳ Order {$paymentRecord->seller_order_no}: Pending authorization");
            } else {
                $newPaymentStatus = 'failed';
                $newStatusMessage = $this->getFPXErrorMessage($fpx_debitAuthCode);
                $this->warn("✗ Order {$paymentRecord->seller_order_no}: Payment FAILED (Code: {$fpx_debitAuthCode})");
            }
            
            if (empty($newPaymentStatus)) {
                return;
            }
            
            $canUpdate = ($paymentRecord->payment_status === 'pending_authorization');
            $statusChanged = ($paymentRecord->payment_status !== $newPaymentStatus);
            
            if ($canUpdate && $statusChanged) {
                $updateData = [
                    'payment_status' => $newPaymentStatus,
                    'status_message' => $newStatusMessage,
                    'updated_at' => now()
                ];
                
                if (!empty($response_value['fpx_fpxTxnId'])) {
                    $updateData['transaction_id'] = $response_value['fpx_fpxTxnId'];
                }
                
                if ($newPaymentStatus === 'completed' && empty($paymentRecord->receipt_number)) {
                    $receiptNumber = $this->generateReceiptNumber();
                    $updateData['receipt_number'] = $receiptNumber;
                }
                
                $updateData['gateway_response'] = json_encode([
                    'latest_status_inquiry' => $response_value,
                    'status_checked_at' => now(),
                    'checked_by' => 'cron_job',
                    'original_fpx_request' => $originalRequest,
                    'query_parameters_used' => [
                        'fpx_sellerExOrderNo' => $fpx_sellerExOrderNo,
                        'fpx_sellerOrderNo' => $fpx_sellerOrderNo,
                        'fpx_sellerTxnTime' => $fpx_sellerTxnTime
                    ]
                ]);
                
                DB::table('payments')
                    ->where('seller_order_no', $paymentRecord->seller_order_no)
                    ->update($updateData);
                
                // ✅ Auto-submit legacy third party request (BEFORE email)
                if ($newPaymentStatus === 'completed' && $paymentRecord->application_id) {
                    $this->autoSubmitLegacyThirdParty($paymentRecord);
                }
                
                // Send email notification if completed
                if ($newPaymentStatus === 'completed') {
                    $this->sendPaymentSuccessEmail($paymentRecord, $response_value);
                }
            }
            
        } catch (\Exception $e) {
            $this->error("Error checking {$paymentRecord->seller_order_no}: {$e->getMessage()}");
            Log::error("FPX Status Check Error", [
                'order' => $paymentRecord->seller_order_no ?? 'unknown',
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * ✅ Auto-submit legacy third party request - EXACT same logic as submitRequest controller
     */
    private function autoSubmitLegacyThirdParty($paymentRecord)
    {
        try {
            if (empty($paymentRecord->application_id)) {
                $this->line("  ⚠ No application_id in payment record");
                return;
            }
            
            // ========================================
            // STEP 1: Get Application (same as controller)
            // ========================================
            $application = Application::find($paymentRecord->application_id);
            
            if (!$application) {
                $this->line("  ⚠ Application #{$paymentRecord->application_id} not found");
                return;
            }
            
            $this->line("  📋 Found application #{$application->id}");
            
            // ========================================
            // STEP 2: Check if legacy (same as controller - before 2025-11-16)
            // ========================================
            if ($application->created_at >= '2025-11-16') {
                $this->line("  ℹ Application uses automatic system (created after 2025-11-16), skipping");
                return;
            }
            
            $this->line("  📅 Legacy application (created: {$application->created_at})");
            
            // ========================================
            // STEP 3: Verify payment (same as controller)
            // ========================================
            $payment = Payment::where('application_id', $paymentRecord->application_id)
                ->where('third_party_id', $paymentRecord->third_party_id)
                ->where('payment_type', 'third_party')
                ->where('payment_status', 'completed')
                ->first();
            
            if (!$payment) {
                $this->line("  ⚠ Payment validation failed - no completed payment found");
                return;
            }
            
            $this->line("  💰 Payment verified (Order: {$payment->seller_order_no})");
            
            // ========================================
            // STEP 4: Check if request already exists (same as controller)
            // ========================================
            $existingRequest = ReceiptRequest::where('application_id', $application->id)
                ->where('third_party_id', $paymentRecord->third_party_id)
                ->first();
            
            if ($existingRequest) {
                $this->line("  ℹ Receipt request already exists (ID: {$existingRequest->id})");
                return;
            }
            
            // ========================================
            // STEP 5: Create receipt request (EXACT same as controller)
            // ========================================
            $receiptRequest = ReceiptRequest::create([
                'application_id' => $application->id,
                'third_party_id' => $paymentRecord->third_party_id,
                'status' => 'pending'
            ]);
            
            $this->info("  ✅ Created receipt request #{$receiptRequest->id}");
            
            // ========================================
            // STEP 6: Notify finance admins (EXACT same as controller)
            // ========================================
            $financeRoleId = '9e032970-5f48-4d2b-b88e-abb9da79140f';
            $financeAdmins = User::where('role_id', $financeRoleId)->get();
            
            if ($financeAdmins->count() === 0) {
                $this->warn("  ⚠ No finance admins found");
                Log::warning('No Finance Admin found', ['role_id' => $financeRoleId]);
            } else {
                foreach ($financeAdmins as $admin) {
                    $admin->notify(new NewReceiptRequestSubmitted($receiptRequest));
                }
                $this->info("  🔔 Notified {$financeAdmins->count()} finance admin(s)");
            }
            
            $this->info("  ✅ AUTO-SUBMIT COMPLETED SUCCESSFULLY!");
            
            // TODO: Send confirmation email to third party user (to be integrated later)
            // $this->sendThirdPartySubmissionEmail($application, $paymentRecord);
            
        } catch (\Exception $e) {
            $this->error("  ❌ Auto-submit failed: {$e->getMessage()}");
            Log::error("Auto-submit third party request failed", [
                'application_id' => $paymentRecord->application_id ?? 'unknown',
                'third_party_id' => $paymentRecord->third_party_id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    /**
     * Send submission confirmation email to third party
     */
    private function sendThirdPartySubmissionEmail($application, $paymentRecord)
    {
        try {
            // Get third party user email
            $thirdParty = DB::table('third_party_users')
                ->where('id', $application->third_party_id)
                ->first();
            
            if (!$thirdParty || !$thirdParty->email) {
                return;
            }
            
            $emailData = [
                'company_name' => $thirdParty->company_name ?? $thirdParty->name ?? 'Dear User',
                'application_ref' => $application->reference_no ?? $application->id,
                'payment_amount' => 'RM ' . number_format($paymentRecord->amount, 2),
                'order_number' => $paymentRecord->seller_order_no,
                'submission_date' => now()->format('d M Y h:i A')
            ];
            
            Mail::send('emails.third-party-auto-submission', $emailData, function($message) use ($thirdParty, $emailData) {
                $message->to($thirdParty->email)
                        ->subject('Receipt Request Submitted - ' . $emailData['application_ref'])
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            $this->line("  ✓ Submission email sent to {$thirdParty->email}");
            
        } catch (\Exception $e) {
            $this->line("  ⚠ Could not send submission email: {$e->getMessage()}");
        }
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
    
    private function sendPaymentSuccessEmail($paymentRecord, $fpxResponse)
    {
        try {
            $userEmail = $paymentRecord->buyer_email;
            
            if (!$userEmail || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                return;
            }
            
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
            
            if ($paymentRecord->application_id) {
                $application = DB::table('applications')
                    ->where('id', $paymentRecord->application_id)
                    ->first();
                
                if ($application) {
                    $emailData['application_ref'] = $application->reference_no ?? '';
                }
            }
            
            Mail::send('emails.payment-success', $emailData, function($message) use ($userEmail, $emailData) {
                $message->to($userEmail)
                        ->subject('Payment Confirmation - Order #' . $emailData['seller_order_no'])
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
                
        } catch (\Exception $e) {
            // Silent fail
        }
    }
}