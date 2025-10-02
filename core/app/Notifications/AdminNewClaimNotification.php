<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AdminNewClaimNotification extends Notification 
{
    use Queueable;

    protected $claim;

    public function __construct($claim)
    {
        $this->claim = $claim;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
       return (new MailMessage)
            ->subject('Permohonan Tuntutan Caruman Diterima Untuk Semakan')
            ->view('emails.admin-new-claim', [
                'claim' => $this->claim,
            ]);
        
    }

    public function toDatabase($notifiable)
    {
        return [
            'claim_id' => $this->claim->id,
            'applicant' => $this->claim->applicant,
            'district' => $this->claim->district,
            'message' => 'Permohonan Tuntutan Caruman Diterima Untuk Semakan',
            'type' => 'new_claim'
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'claim_id' => $this->claim->id,
            'applicant' => $this->claim->applicant,
            'district' => $this->claim->district,
        ];
    }
}