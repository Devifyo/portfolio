<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactFormMail extends Mailable
{
    public function __construct(
        public readonly string $portfolioOwnerName,
        public readonly string $portfolioUrl,
        public readonly string $senderName,
        public readonly string $senderEmail,
        public readonly string $topic,
        public readonly string $userMessage,
    ) {}

    public function envelope(): Envelope
    {
        $rendered = EmailTemplate::render('contact_form', $this->vars());

        return new Envelope(
            replyTo: [$this->senderEmail => $this->senderName],
            subject: $rendered['subject'],
        );
    }

    public function content(): Content
    {
        $rendered = EmailTemplate::render('contact_form', $this->vars());

        return new Content(
            htmlString: $rendered['body'],
        );
    }

    private function vars(): array
    {
        return [
            'portfolio_owner_name' => $this->portfolioOwnerName,
            'portfolio_url'        => $this->portfolioUrl,
            'sender_name'          => $this->senderName,
            'sender_email'         => $this->senderEmail,
            'sender_initial'       => strtoupper(mb_substr($this->senderName, 0, 1)),
            'topic'                => $this->topic,
            'message'              => $this->userMessage,
        ];
    }
}
