<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentApprovedNotification extends Notification
{
    use Queueable;

    public $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Pembayaran anda telah diterima.',
            'application_id' => $this->application->id,
            'receipt_number' => $this->application->reciept_number,
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'receipt_number' => $this->application->reciept_number,
            'message' => 'Your payment has been approved.',
        ];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payment Approved for Application #' . $this->application->id)
            ->view('emails.payment-status', [
                'application' => $this->application,
                'notifiable' => $notifiable
            ]);
    }
}