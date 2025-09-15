<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class AdminAccountUnblockedNotification extends Notification
{
    use Queueable;

    protected $admin;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Admin Account Has Been Unblocked')
                    ->greeting('Hello ' . $this->admin->name . ',')
                    ->line('Your admin account has been unblocked by the superadmin.')
                    ->line('You can now log in using your credentials.')
                    ->line('If you continue to have login issues, please contact the superadmin.')
                    ->action('Login Now', url('/login'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Account Unblocked',
            'message' => 'Your admin account has been unblocked by the superadmin.',
            'admin_id' => $this->admin->uuid,
        ];
    }
}