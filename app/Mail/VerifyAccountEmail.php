<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyAccountEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $recipientName,
        public string $verificationUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirma tu correo electrónico - '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-account',
            text: 'emails.verify-account-text',
            with: [
                'recipientName' => $this->recipientName,
                'verificationUrl' => $this->verificationUrl,
            ],
        );
    }
}
