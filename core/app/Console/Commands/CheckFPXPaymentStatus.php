<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\NewReceiptRequestSubmitted;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PaymentSuccessful;

class CheckFPXPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fpx:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check FPX payment status for pending B2B transactions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting FPX payment status check...');
        
   
        $pendingPayments = DB::table('payments')
            ->where('payment_status', 'pending_authorization')
            ->where('method', 'FPX_B2B')
            ->where('created_at', '>=', now()->subHours(4))
            ->get();
        
        if ($pendingPayments->isEmpty()) {
            $this->info('No pending B2B payments found.');
            return 0;
        }
        
        $this->info("Found {$pendingPayments->count()} pending payment(s) to check.");
        
        foreach ($pendingPayments as $payment) {
            $this->checkPaymentStatus($payment);
        }
        
        $this->info('FPX payment status check completed.');
        return 0;
    }
    
    /**
     * Check status for a single payment
     */
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
            
            // ============================================
            // CRITICAL FIX: Use seller_ex_order_no first!
            // ============================================
            $fpx_sellerExOrderNo = $paymentRecord->seller_ex_order_no ?? $paymentRecord->seller_order_no;
            $fpx_sellerOrderNo = $paymentRecord->seller_order_no;
            $fpx_sellerTxnTime = $paymentRecord->seller_txn_time ?? date('YmdHis', strtotime($paymentRecord->created_at));
            
            // If we have original request data, verify and use it
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
            
            // Use EXACT buyer details from original transaction
            $fpx_buyerEmail = $paymentRecord->buyer_email ?? "";
            $fpx_buyerName = $paymentRecord->buyer_name ?? "";
            $fpx_buyerBankId = $paymentRecord->buyer_bank_id ?? "";
            $fpx_buyerBankBranch = $paymentRecord->buyer_bank_branch ?? "";
            
            // If we have original request, use those exact values
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
            
            $fpx_debitAuthCode = $response_value['fpx_debitAuthCode'] ?? '';
            
            // Update payment status based on response
            $newPaymentStatus = '';
            $newStatusMessage = '';
            
            // Clean the auth code (remove spaces, ensure string)
            $fpx_debitAuthCode = trim((string)$fpx_debitAuthCode);
            
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
            
            // Only update if we have a definitive status
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
                
                // Generate receipt number for completed B2B transactions
                if ($newPaymentStatus === 'completed' && empty($paymentRecord->receipt_number)) {
                    $receiptNumber = $this->generateReceiptNumber();
                    $updateData['receipt_number'] = $receiptNumber;
                }
                
                // Preserve original request data in gateway_response
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
                
                // ============================================
                // 🆕 AUTO-SUBMIT FOR THIRD-PARTY B2B PAYMENTS
                // ============================================
                if ($newPaymentStatus === 'completed' && $paymentRecord->payment_type === 'third_party') {
                    $this->autoSubmitThirdPartyRequest($paymentRecord);
                }
                
                // Send email notification if completed
                if ($newPaymentStatus === 'completed') {
                    $this->sendPaymentSuccessEmail($paymentRecord, $response_value);
                }
            }
            
        } catch (\Exception $e) {
            $this->error("Error checking {$paymentRecord->seller_order_no}: {$e->getMessage()}");
        }
    }



    private function autoSubmitThirdPartyRequest($paymentRecord)
    {
        try {
            if (!$paymentRecord->application_id) {
                $this->warn("⚠ Payment {$paymentRecord->seller_order_no} has no application_id - skipping auto-submit");
                return;
            }
            
            $application = DB::table('applications')
                ->where('id', $paymentRecord->application_id)
                ->first();
            
            if (!$application) {
                $this->warn("⚠ Application ID {$paymentRecord->application_id} not found - skipping auto-submit");
                return;
            }
            
            $isLegacy = \Carbon\Carbon::parse($application->created_at)->lt('2025-11-16');
            
            if (!$isLegacy) {
                $this->line("ℹ Application ID {$application->id} is not legacy (created after 16 Nov 2024) - skipping auto-submit");
                return;
            }
            
            $existingRequest = DB::table('receipt_requests')
                ->where('application_id', $paymentRecord->application_id)
                ->where('third_party_id', $paymentRecord->third_party_id)
                ->first();
            
            if ($existingRequest) {
                $this->line("ℹ Receipt request for Application ID {$application->id} already exists - skipping");
                return;
            }
            
            $receiptRequestId = DB::table('receipt_requests')->insertGetId([
                'application_id' => $paymentRecord->application_id,
                'third_party_id' => $paymentRecord->third_party_id,
                'status' => 'pending',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
            
            $this->info("✅ AUTO-SUBMITTED receipt request (ID: {$receiptRequestId}) for Application ID: {$application->id} (B2B Payment: {$paymentRecord->seller_order_no})");
            
            $this->sendFinanceAdminNotifications($receiptRequestId, $paymentRecord);
            
        } catch (\Exception $e) {
            $this->error("❌ Auto-submit failed for payment {$paymentRecord->seller_order_no}: {$e->getMessage()}");
        }
    }


    private function sendFinanceAdminNotifications($receiptRequestId, $paymentRecord)
    {
        try {
            $financeRoleId = '9e032970-5f48-4d2b-b88e-abb9da79140f';
            
            $financeAdmins = DB::table('users')
                ->where('role_id', $financeRoleId)
                ->get();
            
            if ($financeAdmins->count() === 0) {
                $this->warn("⚠ No Finance Admin found for notifications (role_id: {$financeRoleId})");
                return;
            }
            
            $receiptRequest = \App\Models\ReceiptRequest::find($receiptRequestId);
            
            if (!$receiptRequest) {
                $this->warn("⚠ Receipt request {$receiptRequestId} not found for notifications");
                return;
            }
            
            foreach ($financeAdmins as $admin) {
                try {
                    $adminUser = \App\Models\User::find($admin->uuid);
                    
                    if ($adminUser) {
                        $adminUser->notify(new \App\Notifications\NewReceiptRequestSubmitted($receiptRequest));
                        $this->line("📧 Notification sent to Finance Admin: {$admin->email}");
                    }
                } catch (\Exception $e) {
                    $this->warn("⚠ Failed to notify admin {$admin->email}: {$e->getMessage()}");
                }
            }
            
            $this->info("✅ Sent notifications to {$financeAdmins->count()} Finance Admin(s)");
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to send notifications: {$e->getMessage()}");
        }
    }
    
    /**
     * Generate receipt number
     */
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
    
    /**
     * Get FPX error message
     */
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
    
    /**
     * Send payment success email
     */
    private function sendPaymentSuccessEmail($paymentRecord, $fpxResponse)
    {
        try {
            // Get user email
            $userEmail = $paymentRecord->buyer_email;
            
            if (!$userEmail || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
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
        
            
            // Send email using Laravel Mail
            Mail::send('emails.payment-success', $emailData, function($message) use ($userEmail, $emailData) {
                $message->to($userEmail)
                        ->subject('Payment Confirmation - Order #' . $emailData['seller_order_no'])
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
        
                
        } catch (\Exception $e) {
        }
    }
}