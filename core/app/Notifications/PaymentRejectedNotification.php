<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentRejectedNotification extends Notification
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
            'message' => 'Bayaran anda telah ditolak!.',
            'applicant' => $this->application->applicant,
            'application_id' => $this->application->id,
            'receipt_number' => $this->application->reciept_number,
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'applicant' => $this->application->applicant,
            'receipt_number' => $this->application->reciept_number,
            'message' => 'Bayaran anda telah ditolak.',
        ];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Payment Rejected for Application #' . $this->application->id)
            ->view('emails.payment-reject-status', [
                'application' => $this->application,
                'notifiable' => $notifiable
            ]);
    }
}