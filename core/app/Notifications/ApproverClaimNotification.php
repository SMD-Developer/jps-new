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
            : 'Tuntutan baru telah dihantar untuk kelulusan oleh';

        return [
            'claim_id' => $this->claim->id,
            'type' => 'forward_claim_to_approver',
            'message' => $message,
            'sent_by' => $this->senderUsername,
            'is_resent' => $this->isResent,
            'sent_at' => now()->toDateTimeString(),
        ];
    }

    public function toMail($notifiable)
    {
        $subject = $this->isResent ? 'Tuntutan Dihantar Semula' : 'Tuntutan Baru Untuk Kelulusan';
        $line1 = $this->isResent 
            ? 'Tuntutan yang ditolak telah dihantar semula untuk kelulusan.' 
            : 'Tuntutan baru telah dihantar untuk kelulusan.';

        return (new MailMessage)
            ->subject($subject)
            ->line($line1)
            ->line('Dihantar oleh: ' . $this->senderUsername)
            ->line('Terima kasih!');
    }
}