<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $contactData;

    public function __construct(array $contactData)
    {
        $this->contactData = $contactData;
    }

    public function envelope(): Envelope
    {
        $subject = $this->contactData['subject'] ?? 'Mensaje General';

        return new Envelope(
            subject: "📩 Mensaje de Contacto: {$subject}",
        );
    }

    public function content(): Content
    {
        $company = Company::first();

        return new Content(
            view: 'emails.contact.admin-notification',
            with: [
                'contactData' => $this->contactData,
                'company' => $company,
            ]
        );
    }
}
