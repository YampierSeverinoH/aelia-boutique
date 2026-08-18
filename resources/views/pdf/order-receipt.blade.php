<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pedido #{{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #1F1A1B; margin: 0; padding: 20px; }
        .header { border-b: 2px solid #825159; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #825159; font-family: Georgia, serif; }
        .subtitle { font-size: 10px; color: #B38B4D; text-transform: uppercase; letter-spacing: 2px; }
        .title-box { text-align: right; float: right; }
        .order-num { font-size: 16px; font-weight: bold; color: #825159; }
        .grid-2 { width: 100%; margin-bottom: 20px; }
        .grid-2 td { width: 50%; vertical-align: top; }
        .box { background: #FAF5F5; padding: 12px; border-radius: 6px; border: 1px solid #EBE0E0; }
        .box-title { font-weight: bold; color: #825159; text-transform: uppercase; font-size: 10px; margin-bottom: 6px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 20px; }
        table.items th { background: #825159; color: #ffffff; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        table.items td { padding: 8px; border-bottom: 1px solid #EBE0E0; font-size: 11px; }
        .totals { width: 40%; float: right; border-collapse: collapse; }
        .totals td { padding: 6px; text-align: right; }
        .totals .grand-total { font-size: 14px; font-weight: bold; color: #825159; border-top: 2px solid #825159; }
        .clear { clear: both; }
        .footer { margin-top: 40px; border-t: 1px solid #EBE0E0; pt-10; text-align: center; font-size: 10px; color: #514345; }
        .bank-box { background: #FFF8F7; border: 1px dashed #B38B4D; padding: 10px; margin-top: 20px; border-radius: 6px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title-box">
            <div class="order-num">PEDIDO #{{ $order->order_number }}</div>
            <div style="font-size: 10px; color: #666;">Fecha: {{ $order->created_at->format('d/m/Y H:i') }}</div>
        </div>
        <div class="logo">Aelia Boutique</div>
        <div class="subtitle">Elegancia & Sofisticación en Cada Detalle</div>
    </div>

    <table class="grid-2">
        <tr>
            <td>
                <div class="box">
                    <div class="box-title">Datos del Cliente</div>
                    <strong>Nombre:</strong> {{ $order->customer_name }}<br>
                    <strong>Documento:</strong> {{ $order->document_type ?? 'DNI' }}: {{ $order->document_number ?? '-' }}<br>
                    <strong>Teléfono:</strong> {{ $order->customer_phone }}<br>
                    <strong>Email:</strong> {{ $order->customer_email }}
                </div>
            </td>
            <td style="padding-left: 15px;">
                <div class="box">
                    <div class="box-title">Dirección de Envío</div>
                    <strong>Dirección:</strong> {{ $order->shipping_address }}<br>
                    <strong>Ubicación:</strong> {{ $order->district }}, {{ $order->province }}, {{ $order->region }}<br>
                    <strong>Método Pago:</strong> {{ $order->payment_method_label }}<br>
                    <strong>Estado:</strong> {{ ucfirst($order->order_status ?? 'Pendiente') }}
                </div>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Producto / Prenda</th>
                <th style="text-align: center;">Cantidad</th>
                <th style="text-align: right;">P. Unitario</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                        @if($item->variant_name)
                            <div style="font-size: 10px; color: #666;">Variante: {{ $item->variant_name }}</div>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">S/ {{ number_format($item->price, 2) }}</td>
                    <td style="text-align: right;">S/ {{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal:</td>
            <td>S/ {{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>Costo de Envío:</td>
            <td>S/ {{ number_format($order->shipping_cost, 2) }}</td>
        </tr>
        <tr class="grand-total">
            <td>TOTAL:</td>
            <td>S/ {{ number_format($order->total, 2) }}</td>
        </tr>
    </table>

    <div class="clear"></div>

    @if(isset($bankAccounts) && $bankAccounts->isNotEmpty())
        <div class="bank-box">
            <div class="box-title">Cuentas Bancarias para Pago / Yape / Plin</div>
            @foreach($bankAccounts as $bank)
                <div style="font-size: 11px; margin-bottom: 4px;">
                    <strong>{{ $bank->bank_name }}:</strong> N° Cuenta {{ $bank->account_number }} 
                    @if($bank->cci) | CCI: {{ $bank->cci }} @endif
                    | Titular: {{ $bank->holder_name }}
                </div>
            @endforeach
            <div style="font-size: 10px; color: #825159; margin-top: 6px;">
                💡 Por favor envía tu comprobante de pago por WhatsApp al {{ optional($company)->telefono ?? '+51 987 654 321' }} adjuntando el código de pedido #{{ $order->order_number }}.
            </div>
        </div>
    @endif

    <div class="footer">
        {{ optional($company)->direccion ?? 'Av. Conquistadores 789, San Isidro, Lima - Perú' }} | 
        Email: {{ optional($company)->correo ?? 'contacto@aeliaboutique.pe' }} | 
        Web: aeliastore.pe
    </div>

</body>
</html>
