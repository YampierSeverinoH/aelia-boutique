<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class OrderDocumentController extends Controller
{
    /**
     * Generar comprobante en formato PDF A4 estándar.
     */
    public function pdf(Order $order)
    {
        $company = Company::first();
        $bankAccounts = BankAccount::active()->get();

        $pdf = Pdf::loadView('pdf.order-receipt', compact('order', 'bankAccounts', 'company'));

        return $pdf->stream("Comprobante-Pedido-{$order->order_number}.pdf");
    }

    /**
     * Generar comprobante en formato Ticket Térmico 80mm (Boleta de Venta).
     */
    public function ticket(Order $order)
    {
        $company = Company::first();
        $bankAccounts = BankAccount::active()->get();

        // 80mm en puntos pt (80mm ≈ 226.77 pt)
        $pdf = Pdf::loadView('pdf.order-ticket', compact('order', 'bankAccounts', 'company'))
            ->setPaper([0, 0, 226.77, 650]);

        return $pdf->stream("Ticket-Pedido-{$order->order_number}.pdf");
    }
}
