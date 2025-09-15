<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OtpVerificationNotification extends Notification
{
    use Queueable;

    public $otp;
    public $userName;

    public function __construct($otp, $userName = null)
    {
        $this->otp = $otp;
        $this->userName = $userName;
    }

    public function via($notifiable)
    {
        return ['mail']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Email Verification - OTP Code')
            ->view('emails.otp', [
                'otp' => $this->otp,
                'userName' => $this->userName,
                'notifiable' => $notifiable
            ]);
    }
}