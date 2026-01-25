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
        $application = $this->receiptRequest->application;
        $thirdParty = $this->receiptRequest->thirdParty;
        
        return (new MailMessage)
            ->subject('Resit Permintaan Diserahkan')
            ->view('emails.receipt-request-submitted', [
                'receiptRequest' => $this->receiptRequest,
                'application' => $application,
                'thirdParty' => $thirdParty
            ]);
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
