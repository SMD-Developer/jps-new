<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserApplicationRejectionNotification extends Notification
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
            'message' => 'Permohonan anda ditolak',
            'application_id' => $this->application->id,
            'applicant' => $this->application->applicant,
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'applicant' => $this->application->applicant,
            'message' => 'Permohonan anda ditolak',
        ];
    }


    public function toMail($notifiable)
    {
            return (new MailMessage)
                ->subject('Permohonan Ditolak')
                ->view('emails.userRegistration', [
                    'application' => $this->application,
                    'notifiable' => $notifiable
                ]);
    }
}