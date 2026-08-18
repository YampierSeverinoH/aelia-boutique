<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $order->order_number }}</title>
    <style>
        @page {
            margin: 5px 8px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #000;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .text-subtitle {
            font-size: 10px;
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .divider-solid {
            border-top: 1px solid #000;
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 2px 0;
            vertical-align: top;
        }

        .item-name {
            word-wrap: break-word;
            max-width: 120px;
        }

        .totals-table td {
            padding: 1px 0;
        }

        .footer {
            margin-top: 6px;
            font-size: 9px;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <div class="text-title">AELIA BOUTIQUE</div>
        @if (optional($company)->ruc)
            <div>RUC: {{ $company->ruc }}</div>
        @endif
        @if (optional($company)->direccion)
            <div>{{ $company->direccion }}</div>
        @endif
        @if (optional($company)->telefono)
            <div>Telf: {{ $company->telefono }}</div>
        @endif
    </div>

    <div class="divider"></div>

    <div class="text-center">
        <div class="text-subtitle">NOTA DE VENTA</div>
        <div class="font-bold">N° {{ $order->order_number }}</div>
    </div>

    <div class="divider"></div>

    <div>
        <div><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</div>
        <div><strong>Cliente:</strong> {{ $order->customer_name }}</div>
        @if ($order->customer_dni)
            <div><strong>DNI/RUC:</strong> {{ $order->customer_dni }}</div>
        @endif
        @if ($order->customer_phone)
            <div><strong>Teléfono:</strong> {{ $order->customer_phone }}</div>
        @endif
        <div><strong>Envío:</strong> {{ $order->district }}, {{ $order->province }}</div>
        <div><strong>Pago:</strong> {{ $order->payment_method_label }}</div>
        <div><strong>Estado:</strong> {{ ucfirst($order->order_status ?? 'Pendiente') }}</div>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr style="border-bottom: 1px solid #000;">
                <th class="text-left" style="width: 15%;">Cant</th>
                <th class="text-left" style="width: 55%;">Producto</th>
                <th class="text-right" style="width: 30%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td class="text-left font-bold">{{ $item->quantity }}</td>
                    <td class="text-left item-name">
                        {{ $item->product_name }}
                        @if ($item->variant_name)
                            <div style="font-size: 8px; color: #444;">({{ $item->variant_name }})</div>
                        @endif
                    </td>
                    <td class="text-right">S/ {{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <table class="totals-table">
        <tr>
            <td class="text-left">Subtotal:</td>
            <td class="text-right">S/ {{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td class="text-left">Envío:</td>
            <td class="text-right">S/ {{ number_format($order->shipping_cost, 2) }}</td>
        </tr>
        <tr style="font-weight: bold; font-size: 11px;">
            <td class="text-left">TOTAL:</td>
            <td class="text-right">S/ {{ number_format($order->total, 2) }}</td>
        </tr>
    </table>

    <div class="divider-solid"></div>

    <div class="text-center footer">
        <div>¡Gracias por tu compra en AELIA BOUTIQUE!</div>
        <div style="margin-top: 2px;">www.aeliastore.pe</div>
    </div>
</body>

</html>
