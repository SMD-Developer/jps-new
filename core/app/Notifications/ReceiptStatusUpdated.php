<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReceiptStatusUpdated extends Notification
{
    use Queueable;

    protected $receipt;

    public function __construct($receipt)
    {
        $this->receipt = $receipt;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Status Permohonan Salinan Resit')
            ->view('emails.receipt_status', [
                'notifiable' => $notifiable,
                'receipt'    => $this->receipt,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'receipt_id' => $this->receipt->id,
            'status'     => $this->receipt->status,
            'notes'      => $this->receipt->admin_notes,
        ];
    }
}
