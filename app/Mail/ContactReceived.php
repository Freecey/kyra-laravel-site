<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contactMessage) {}

    public function envelope(): Envelope
    {
        $prefix = \App\Models\Setting::get('notification_subject', '[KYRA] Nouveau message');

        return new Envelope(
            subject: $prefix . ' : ' . $this->contactMessage->subject,
            replyTo: [
                new \Illuminate\Mail\Mailables\Address(
                    $this->contactMessage->email,
                    $this->contactMessage->name
                ),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-received',
        );
    }
}
