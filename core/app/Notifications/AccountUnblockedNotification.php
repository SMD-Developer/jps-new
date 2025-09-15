<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountUnblockedNotification extends Notification 
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Account Unblocked')
            ->view('emails.accountUnblocked', [
                'user' => $this->user
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Account Unblocked',
            'message' => 'Your account has been successfully unblocked. You can now log in normally.',
            'type' => 'account_unblocked',
            'user_id' => $this->user->client_id,
        ];
    }
}