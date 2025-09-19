<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

    class WelcomeEmail extends Mailable
    {
        use Queueable, SerializesModels;
    
        public $userName;
    
        /**
         * Create a new message instance.
         */
        public function __construct($userName)
        {
            $this->userName = $userName;
        }
    
        /**
         * Build the message.
         */
        public function build()
        {
           return $this->subject('Selamat Dantang ke JPS')
                ->view('emails.welcome');
        }
    }