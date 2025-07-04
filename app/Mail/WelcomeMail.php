<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
       return new Envelope(
        subject: 'Welcome to Our Platform',
        cc: [
            new Address('cc@example.com', 'CC Recipient'), // ✅ Replace with real address
        ],
        bcc: [
            new Address('bcc@example.com', 'BCC Recipient'), // ✅ Replace with real address
        ]
    );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome', // ✅ Make sure this view exists
            with: [
                'user' => $this->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
