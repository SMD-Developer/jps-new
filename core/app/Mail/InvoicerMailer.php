<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicerMailer extends Mailable
{
    use Queueable, SerializesModels;
    public array $params;

    /**
     * Create a new message instance.
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: $this->params['subject'] ?? 'Email from '.env('APP_NAME')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if($this->params['template_type'] === 'view'){
            return new Content(
                view:  $this->params['template'],
                with: $this->params['data']
            );
        }
        return new Content(
            markdown:  $this->params['template'],
            with: $this->params['data']
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return Attachment
     */
    public function attachments(): Attachment
    {
        return Attachment::fromPath($this->params['attachment']);
    }
}
