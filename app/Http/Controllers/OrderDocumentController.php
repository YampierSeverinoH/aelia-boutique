<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderDocumentController extends Controller
{
    /**
     * Generar comprobante en formato PDF A4 estándar.
     */
    public function pdf(Order $order)
    {
        try {
            $fontDir = storage_path('fonts');
            if (!file_exists($fontDir)) {
                @mkdir($fontDir, 0777, true);
            }

            $company = Company::first();
            $bankAccounts = BankAccount::active()->get();

            $pdf = Pdf::loadView('pdf.order-receipt', compact('order', 'bankAccounts', 'company'));

            return $pdf->stream("Comprobante-Pedido-{$order->order_number}.pdf");
        } catch (Throwable $e) {
            Log::error("PDF Generation Error: {$e->getMessage()}", [
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return response("<div style='font-family: system-ui, sans-serif; max-width: 600px; margin: 40px auto; padding: 24px; border: 1px solid #e5a8b1; background: #fff8f7; border-radius: 12px;'>
                <h3 style='color: #825159; margin-top: 0;'>⚠️ Error al generar Comprobante PDF</h3>
                <p style='color: #514345; font-size: 14px;'>No se pudo procesar el PDF del pedido #{$order->order_number}.</p>
                <div style='background: #fff; padding: 12px; border-radius: 6px; border: 1px solid #d5c2c4; font-family: monospace; font-size: 12px; color: #ba1a1a;'>
                    <strong>Detalle técnico:</strong> " . htmlspecialchars($e->getMessage()) . "
                </div>
                <p style='color: #837375; font-size: 12px; margin-bottom: 0; margin-top: 16px;'>Asegúrate de ejecutar <code>chmod -R 777 storage</code> en cPanel para dar permisos a la carpeta de fuentes de PDF.</p>
            </div>", 500);
        }
    }

    /**
     * Generar comprobante en formato Ticket Térmico 80mm (Boleta de Venta).
     */
    public function ticket(Order $order)
    {
        try {
            $fontDir = storage_path('fonts');
            if (!file_exists($fontDir)) {
                @mkdir($fontDir, 0777, true);
            }

            $company = Company::first();
            $bankAccounts = BankAccount::active()->get();

            // 80mm en puntos pt (80mm ≈ 226.77 pt)
            $pdf = Pdf::loadView('pdf.order-ticket', compact('order', 'bankAccounts', 'company'))
                ->setPaper([0, 0, 226.77, 650]);

            return $pdf->stream("Ticket-Pedido-{$order->order_number}.pdf");
        } catch (Throwable $e) {
            Log::error("Ticket Generation Error: {$e->getMessage()}", [
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return response("<div style='font-family: system-ui, sans-serif; max-width: 600px; margin: 40px auto; padding: 24px; border: 1px solid #e5a8b1; background: #fff8f7; border-radius: 12px;'>
                <h3 style='color: #825159; margin-top: 0;'>⚠️ Error al generar Ticket 80mm</h3>
                <p style='color: #514345; font-size: 14px;'>No se pudo procesar el Ticket del pedido #{$order->order_number}.</p>
                <div style='background: #fff; padding: 12px; border-radius: 6px; border: 1px solid #d5c2c4; font-family: monospace; font-size: 12px; color: #ba1a1a;'>
                    <strong>Detalle técnico:</strong> " . htmlspecialchars($e->getMessage()) . "
                </div>
                <p style='color: #837375; font-size: 12px; margin-bottom: 0; margin-top: 16px;'>Asegúrate de ejecutar <code>chmod -R 777 storage</code> en cPanel para dar permisos a la carpeta de fuentes de PDF.</p>
            </div>", 500);
        }
    }
}
