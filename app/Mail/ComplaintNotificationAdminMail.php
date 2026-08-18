<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintNotificationAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $claimData;

    public function __construct(array $claimData)
    {
        $this->claimData = $claimData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "⚠️ Nuevo Registro en Libro de Reclamaciones N° {$this->claimData['code']}",
        );
    }

    public function content(): Content
    {
        $company = Company::first();

        return new Content(
            view: 'emails.complaints.admin-notification',
            with: [
                'claimData' => $this->claimData,
                'company' => $company,
            ]
        );
    }
}
