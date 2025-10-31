<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                $originalRequest = $gatewayData['fpx_response_data'] ?? $gatewayData['latest_status_inquiry'] ?? null;
            }
            
            // Use the EXACT sellerExOrderNo from the original transaction
            $fpx_sellerExOrderNo = $paymentRecord->seller_order_no;
            
            // If we have the original response, use that exact order number
            if ($originalRequest && !empty($originalRequest['fpx_sellerExOrderNo'])) {
                $fpx_sellerExOrderNo = $originalRequest['fpx_sellerExOrderNo'];
                $this->line("Using original FPX order number: {$fpx_sellerExOrderNo}");
            }
            
            // Also get the exact transaction time from original request
            $fpx_sellerTxnTime = $paymentRecord->seller_txn_time ?? date('YmdHis', strtotime($paymentRecord->created_at));
            if ($originalRequest && !empty($originalRequest['fpx_sellerTxnTime'])) {
                $fpx_sellerTxnTime = $originalRequest['fpx_sellerTxnTime'];
                $this->line("Using original transaction time: {$fpx_sellerTxnTime}");
            }
            
            // Get exact seller order number (not exchange order number)
            $fpx_sellerOrderNo = $paymentRecord->seller_order_no;
            if ($originalRequest && !empty($originalRequest['fpx_sellerOrderNo'])) {
                $fpx_sellerOrderNo = $originalRequest['fpx_sellerOrderNo'];
            }

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
            
            // Log what we're sending to FPX
            Log::info('FPX Status Query Parameters', [
                'order_no' => $paymentRecord->seller_order_no,
                'fpx_sellerExOrderNo' => $fpx_sellerExOrderNo,
                'fpx_sellerOrderNo' => $fpx_sellerOrderNo,
                'fpx_sellerTxnTime' => $fpx_sellerTxnTime,
                'fpx_txnAmount' => $fpx_txnAmount,
                'fpx_buyerName' => $fpx_buyerName,
                'fpx_buyerBankId' => $fpx_buyerBankId,
            ]);
            
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
            
            // LOG THE ACTUAL RESPONSE
            Log::info('FPX Status Response for Order', [
                'order_no' => $paymentRecord->seller_order_no,
                'debit_auth_code' => $fpx_debitAuthCode,
                'fpx_transaction_id' => $response_value['fpx_fpxTxnId'] ?? 'N/A',
                'full_response' => $response_value,
                'current_db_status' => $paymentRecord->payment_status,
                'query_used' => [
                    'fpx_sellerExOrderNo' => $fpx_sellerExOrderNo,
                    'fpx_sellerOrderNo' => $fpx_sellerOrderNo,
                    'fpx_sellerTxnTime' => $fpx_sellerTxnTime
                ]
            ]);
            
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
                // Still pending
                $newPaymentStatus = 'pending_authorization';
                $newStatusMessage = 'Payment is pending for authorizer approval';
                $this->line("⏳ Order {$paymentRecord->seller_order_no}: Still pending");
            } elseif ($fpx_debitAuthCode === '76') {
                // Transaction not found - but we have a transaction ID from before!
                if (!empty($originalRequest['fpx_fpxTxnId'])) {
                    $this->warn("⚠ Order {$paymentRecord->seller_order_no}: Code 76 but transaction ID exists ({$originalRequest['fpx_fpxTxnId']})");
                    $this->warn("   This might be a completed transaction. Manual verification recommended.");
                    
                    Log::warning('FPX Code 76 with Existing Transaction ID', [
                        'order_no' => $paymentRecord->seller_order_no,
                        'fpx_txn_id' => $originalRequest['fpx_fpxTxnId'],
                        'last_known_status' => $originalRequest['fpx_debitAuthCode'] ?? 'unknown',
                        'action' => 'REQUIRES MANUAL VERIFICATION - Transaction may be completed but not queryable'
                    ]);
                    
                    // Don't mark as failed - keep pending for manual review
                    return;
                }
                
                $this->warn("⚠ Order {$paymentRecord->seller_order_no}: Transaction not found in FPX (Code 76)");
                // Don't update status - manual verification needed
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
                    
                    Log::info('B2B Receipt Generated by Cron', [
                        'order_no' => $paymentRecord->seller_order_no,
                        'receipt_number' => $receiptNumber,
                        'transaction_id' => $response_value['fpx_fpxTxnId'] ?? 'N/A'
                    ]);
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
                
                // Send email notification if completed
                if ($newPaymentStatus === 'completed') {
                    $this->sendPaymentSuccessEmail($paymentRecord, $response_value);
                }
            }
            
        } catch (\Exception $e) {
            $this->error("Error checking {$paymentRecord->seller_order_no}: {$e->getMessage()}");
            Log::error('FPX Cron Status Check Failed', [
                'order_no' => $paymentRecord->seller_order_no,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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
        
            
            // Send email using Laravel Mail
            Mail::send('emails.payment-success', $emailData, function($message) use ($userEmail, $emailData) {
                $message->to($userEmail)
                        ->subject('Payment Confirmation - Order #' . $emailData['seller_order_no'])
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
        
                
        } catch (\Exception $e) {
            Log::error('Failed to send payment success email', [
                'order_no' => $paymentRecord->seller_order_no,
                'email' => $userEmail ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}