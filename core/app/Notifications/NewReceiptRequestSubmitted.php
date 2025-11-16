<?php

namespace App\Notifications;

use App\Models\ReceiptRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReceiptRequestSubmitted extends Notification
{
    use Queueable;

    public $receiptRequest;

    public function __construct(ReceiptRequest $receiptRequest)
    {
        $this->receiptRequest = $receiptRequest;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Receipt Request Submitted')
            ->line('A new receipt request has been submitted by a third party.')
            ->line('Application ID: ' . $this->receiptRequest->application_id)
            ->line('Third Party ID: ' . $this->receiptRequest->third_party_id)
            ->line('Please review it as soon as possible.');
    }

    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->receiptRequest->application_id,
            'third_party_id' => $this->receiptRequest->third_party_id,
            'message' => 'New receipt request submitted.'
        ];
    }
}
