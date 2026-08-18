<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderNotificationAdminMail extends Mailable
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
            subject: "🚨 ¡Nuevo Pedido Recibido! #{$this->order->order_number} - S/ " . number_format($this->order->total, 2),
        );
    }

    public function content(): Content
    {
        $company = Company::first();

        return new Content(
            view: 'emails.orders.admin-notification',
            with: [
                'order' => $this->order,
                'company' => $company,
            ]
        );
    }
}
