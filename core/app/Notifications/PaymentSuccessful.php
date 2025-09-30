<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessful extends Notification
{
    use Queueable;

    protected $paymentData;

    public function __construct($paymentData)
    {
        $this->paymentData = $paymentData;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payment Successful - Order #' . $this->paymentData['order_no'])
            ->view('emails.fpx-payment-success', [
                'buyerName' => $this->paymentData['buyer_name'],
                'orderNo' => $this->paymentData['order_no'],
                'transactionId' => $this->paymentData['transaction_id'],
                'amount' => $this->paymentData['amount'],
                'currency' => $this->paymentData['currency'],
                'bankName' => $this->paymentData['bank_name'],
                'paymentDate' => $this->paymentData['payment_date'],
                'dashboardUrl' => url('/dashboard') // or your dashboard route
            ]);
    }
}