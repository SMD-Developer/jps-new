<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ApproverClaimNotification extends Notification
{
    use Queueable;

    protected $claim;
    protected $senderUsername;

    public function __construct($claim, $senderUsername, $isResent = false)
    {
        $this->claim = $claim;
        $this->senderUsername = $senderUsername;
        $this->isResent = $isResent;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // Choose your notification channels
    }

    public function toArray($notifiable)
    {
        $message = $this->isResent 
            ? 'Tuntutan yang ditolak telah dihantar semula untuk kelulusan oleh '
            : 'Permohonon Tuntutan Pulang Balik Diterima Untuk Semakan';

        return [
            'claim_id' => $this->claim->id,
            'type' => 'forward_claim_to_approver',
            'message' => $message,
            'sent_by' => $this->senderUsername,
            'sent_to' => $notifiable->name ?? $notifiable->username ?? $notifiable->email, 
            'sent_to_id' => $notifiable->id ?? $notifiable->uuid, 
            'is_resent' => $this->isResent,
            'sent_at' => now()->toDateTimeString(),
        ];
    }

    public function toMail($notifiable)
    {
        $subject = $this->isResent ? 'Permohonan Tuntutan Pulang Balik Diterima untuk Semakan' : 'Permohonan Tuntutan Pulang Balik Diterima untuk Semakan';

        $recipientName = $notifiable->name 
            ?? $notifiable->username 
            ?? $notifiable->email 
            ?? 'Pegawai Pelulus';

        $mainMessage = $this->isResent 
            ? 'Tuntutan yang ditolak telah dihantar semula untuk kelulusan.' 
            : 'Tuntutan baru telah dihantar untuk kelulusan.';

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.claim-approver-email', [
                'claim' => $this->claim,
                'senderUsername' => $this->senderUsername,
                'subject' => $subject,
                'mainMessage' => $mainMessage,
                'recipientName' => $recipientName,
                'notifiable' => $notifiable,
                'sentAt' => now()->format('d/m/Y H:i'),
                'loginUrl' => url('/clientarea/login'),
            ]);
    }
}