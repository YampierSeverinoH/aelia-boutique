<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF5F5; color: #1F1A1B; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #EBE0E0; }
        .header { text-align: center; border-bottom: 1px solid #EBE0E0; padding-bottom: 20px; margin-bottom: 25px; }
        .logo { font-size: 26px; font-weight: bold; color: #825159; font-family: Georgia, serif; }
        .badge { background: #825159; color: #ffffff; padding: 4px 12px; font-size: 11px; font-weight: bold; border-radius: 20px; text-transform: uppercase; }
        .box { background: #FAF5F5; border-radius: 8px; padding: 15px; margin-bottom: 20px; font-size: 13px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 20px; }
        table.items th { background: #825159; color: #ffffff; padding: 8px; font-size: 11px; text-transform: uppercase; text-align: left; }
        table.items td { padding: 10px 8px; border-bottom: 1px solid #EBE0E0; font-size: 13px; }
        .btn { display: inline-block; background: #1A1A1A; color: #ffffff !important; text-decoration: none; padding: 12px 24px; font-size: 12px; font-weight: bold; text-transform: uppercase; border-radius: 6px; }
        .footer { text-align: center; font-size: 11px; color: #514345; margin-top: 30px; border-top: 1px solid #EBE0E0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Aelia Boutique</div>
            <p style="margin-top: 5px; font-size: 12px; color: #B38B4D; text-transform: uppercase; tracking-widest;">Elegancia & Sofisticación en Cada Detalle</p>
        </div>

        <h2 style="color: #825159; margin-top: 0;">¡Gracias por tu compra, {{ $order->customer_name }}!</h2>
        <p style="font-size: 14px; line-height: 1.6;">
            Hemos recibido tu pedido con éxito. Adjunto a este correo encontrarás el comprobante y resumen detallado en formato <strong>PDF</strong>.
        </p>

        <div class="box">
            <strong>Resumen de Pedido:</strong> #{{ $order->order_number }}<br>
            <strong>Estado:</strong> <span class="badge">{{ ucfirst($order->order_status ?? 'Pendiente') }}</span><br>
            <strong>Total a Pagar:</strong> <strong style="color: #825159;">S/ {{ number_format($order->total, 2) }}</strong><br>
            <strong>Método de Pago:</strong> {{ $order->payment_method_label }}
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Prenda</th>
                    <th style="text-align: center;">Cant.</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product_name }}</strong>
                            @if($item->variant_name)
                                <div style="font-size: 11px; color: #666;">Variante: {{ $item->variant_name }}</div>
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">S/ {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(isset($bankAccounts) && $bankAccounts->isNotEmpty())
            <div style="background: #FFF8F7; border: 1px dashed #B38B4D; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 12px;">
                <strong style="color: #825159;">Datos para Realizar tu Depósito / Yape / Plin:</strong>
                <ul style="padding-left: 20px; margin-top: 8px; margin-bottom: 8px;">
                    @foreach($bankAccounts as $bank)
                        <li>
                            <strong>{{ $bank->bank_name }}:</strong> N° {{ $bank->account_number }} 
                            @if($bank->cci) (CCI: {{ $bank->cci }}) @endif - Titular: {{ $bank->holder_name }}
                        </li>
                    @endforeach
                </ul>
                <p style="margin: 0; color: #825159; font-weight: bold;">
                    📲 Recuerda enviar la captura del pago a nuestro WhatsApp {{ optional($company)->telefono ?? '+51 987 654 321' }} indicando tu número de pedido #{{ $order->order_number }}.
                </p>
            </div>
        @endif

        <div style="text-align: center; margin-top: 25px;">
            <a href="{{ route('tracking.index') }}" class="btn">Rastrear mi Pedido</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Aelia Boutique. Todos los derechos reservados.<br>
            {{ optional($company)->direccion ?? 'San Isidro, Lima - Perú' }}
        </div>
    </div>
</body>
</html>
