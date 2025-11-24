<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class FinanceClaimNotification extends Notification 
{
    use Queueable;

    protected $claim;
    protected $sentBy;

    public function __construct($claim, $sentBy = null)
    {
        $this->claim = $claim;
        $this->sentBy = $sentBy ?? 'System';
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Permohonan pulang balik telah dihantar untuk semakan')
            ->view('emails.staff-forward-claim', [
                'claim' => $this->claim,
                'sentBy' => $this->sentBy,
            ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'claim_id' => $this->claim->id ?? null,
            'applicant' => $this->claim->applicant ?? 'N/A',
            'district' => $this->claim->district ?? 'N/A',
            'sent_by' => $this->sentBy,
            'message' => 'Permohonan pulang balik telah dihantar untuk semakan',
            'type' => 'forward_claim_to_finance'
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'claim_id' => $this->claim->id ?? null,
            'applicant' => $this->claim->applicant ?? 'N/A',
            'district' => $this->claim->district ?? 'N/A',
            'sent_by' => $this->sentBy,
        ];
    }
}