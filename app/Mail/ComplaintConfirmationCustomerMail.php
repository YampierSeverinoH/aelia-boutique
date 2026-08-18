<?php

namespace App\Mail;

use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintConfirmationCustomerMail extends Mailable
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
            subject: "Constancia Libro de Reclamaciones N° {$this->claimData['code']} - Aelia Boutique",
        );
    }

    public function content(): Content
    {
        $company = Company::first();

        return new Content(
            view: 'emails.complaints.customer-confirmation',
            with: [
                'claimData' => $this->claimData,
                'company' => $company,
            ]
        );
    }

    public function attachments(): array
    {
        $company = Company::first();
        $claimData = $this->claimData;

        $pdf = Pdf::loadView('pdf.complaint-sheet', compact('claimData', 'company'));

        return [
            Attachment::fromData(fn () => $pdf->output(), "Hoja-Reclamacion-{$this->claimData['code']}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
