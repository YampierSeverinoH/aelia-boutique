<?php

namespace App\Mail;

use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Confirmación de Pedido #{$this->order->order_number} - Aelia Boutique",
        );
    }

    public function content(): Content
    {
        $company = Company::first();
        $bankAccounts = BankAccount::active()->get();

        return new Content(
            view: 'emails.orders.customer-confirmation',
            with: [
                'order' => $this->order,
                'company' => $company,
                'bankAccounts' => $bankAccounts,
            ]
        );
    }

    public function attachments(): array
    {
        $company = Company::first();
        $bankAccounts = BankAccount::active()->get();
        $order = $this->order;

        $pdf = Pdf::loadView('pdf.order-receipt', compact('order', 'bankAccounts', 'company'));

        return [
            Attachment::fromData(fn () => $pdf->output(), "Comprobante-Pedido-{$this->order->order_number}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
