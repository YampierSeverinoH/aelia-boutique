<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF5F5; color: #1F1A1B; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #EBE0E0; }
        .header { text-align: center; border-bottom: 2px solid #825159; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #825159; font-family: Georgia, serif; }
        .alert-badge { background: #B38B4D; color: #ffffff; padding: 6px 16px; font-size: 12px; font-weight: bold; border-radius: 20px; text-transform: uppercase; display: inline-block; }
        .box { background: #FAF5F5; border-radius: 8px; padding: 15px; margin-bottom: 20px; font-size: 13px; border: 1px solid #EBE0E0; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 20px; }
        table.items th { background: #825159; color: #ffffff; padding: 8px; font-size: 11px; text-transform: uppercase; text-align: left; }
        table.items td { padding: 10px 8px; border-bottom: 1px solid #EBE0E0; font-size: 13px; }
        .btn { display: inline-block; background: #825159; color: #ffffff !important; text-decoration: none; padding: 12px 24px; font-size: 12px; font-weight: bold; text-transform: uppercase; border-radius: 6px; }
        .footer { text-align: center; font-size: 11px; color: #514345; margin-top: 30px; border-top: 1px solid #EBE0E0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Aelia Boutique</div>
            <p style="margin-top: 5px; font-size: 11px; color: #825159; text-transform: uppercase;">Panel Administrativo de Ventas</p>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <span class="alert-badge">🚨 ¡Nuevo Pedido Recibido!</span>
        </div>

        <div class="box">
            <strong>Número de Pedido:</strong> #{{ $order->order_number }}<br>
            <strong>Monto Total:</strong> <span style="font-size: 16px; font-weight: bold; color: #825159;">S/ {{ number_format($order->total, 2) }}</span><br>
            <strong>Estado:</strong> {{ ucfirst($order->order_status ?? 'Pendiente') }}<br>
            <strong>Cliente:</strong> {{ $order->customer_name }} ({{ $order->document_type }}: {{ $order->document_number }})<br>
            <strong>Email:</strong> {{ $order->customer_email }}<br>
            <strong>Teléfono:</strong> {{ $order->customer_phone }}<br>
            <strong>Dirección de Envío:</strong> {{ $order->shipping_address }}, {{ $order->district }}, {{ $order->province }}, {{ $order->region }}<br>
            <strong>Método de Pago:</strong> {{ $order->payment_method_label }}
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="text-align: center;">Cantidad</th>
                    <th style="text-align: right;">Subtotal</th>
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

        <div style="text-align: center; margin-top: 25px;">
            <a href="{{ url('/admin/orders/' . $order->id . '/edit') }}" class="btn">Gestionar Pedido en Panel Admin</a>
        </div>

        <div class="footer">
            Notificación automática enviada a la administración de Aelia Boutique.
        </div>
    </div>
</body>
</html>
