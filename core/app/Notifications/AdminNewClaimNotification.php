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
            ->subject('New Claim Contribution Submitted')
            ->greeting('Hello Admin,')
            ->line('A new claim contribution has been submitted.')
            ->line('Applicant: ' . $this->claim->applicant)
            ->line('District: ' . $this->claim->district)
            ->line('Land Area: ' . $this->claim->land_area . ' ' . $this->claim->land_unit)
            ->action('View Claim', url('/admin/claims/' . $this->claim->id))
            ->line('Please review and process this claim at your earliest convenience.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'claim_id' => $this->claim->id,
            'applicant' => $this->claim->applicant,
            'district' => $this->claim->district,
            'message' => 'New claim contribution submitted by ' . $this->claim->applicant,
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