<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewApplicationSent extends Notification
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
            'message' => 'Permohonan Diterima Untuk Semakan',
            'application_id' => $this->application->id,
            'applicant' => $this->application->applicant,
            'created_at' => now()->toDateTimeString(),
        ];
    }


    public function toMail($notifiable)
    {
            return (new MailMessage)
                ->subject('Permohonan Diterima Untuk Semakan')
                ->view('emails.approverApplication', [
                    'application' => $this->application,
                    'notifiable' => $notifiable
                ]);
    }
}