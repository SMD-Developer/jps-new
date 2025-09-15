<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DepositReceiptSubmitted extends Notification
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
            'message' => 'Resit pembayaran telah dihantar untuk semakan.',
            'application_id' => $this->application->id,
            'transaction' => $this->application->transaction,
            'applicant' => $this->application->applicant,
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'applicant' => $this->application->applicant,
            'message' => 'Resit pembayaran telah dihantar untuk semakan',
        ];
    }


    public function toMail($notifiable)
    {
            return (new MailMessage)
            ->subject('Resit Deposit Baru Dihantar')
                ->view('emails.deposit-rciept', [
                    'application' => $this->application,
                    'notifiable' => $notifiable
                ]);
    }
}