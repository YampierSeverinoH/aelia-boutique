<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoja de Reclamación N° {{ $claimData['code'] }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #1F1A1B; margin: 0; padding: 15px; }
        .header { border-bottom: 2px solid #825159; padding-bottom: 10px; margin-bottom: 15px; }
        .logo { font-size: 20px; font-weight: bold; color: #825159; font-family: Georgia, serif; }
        .title { font-size: 14px; font-weight: bold; text-align: center; color: #825159; margin-top: 10px; margin-bottom: 15px; text-transform: uppercase; border: 1px solid #825159; padding: 6px; background: #FAF5F5; }
        .section-title { font-weight: bold; background: #825159; color: #ffffff; padding: 4px 8px; font-size: 10px; text-transform: uppercase; margin-top: 10px; margin-bottom: 8px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.data-table td { padding: 5px; border: 1px solid #EBE0E0; font-size: 10px; vertical-align: top; }
        table.data-table td.label { font-weight: bold; background: #FAF5F5; width: 30%; color: #514345; }
        .text-box { border: 1px solid #EBE0E0; padding: 8px; background: #FFF8F7; min-h: 50px; font-size: 10px; margin-bottom: 10px; }
        .legal-notice { font-size: 9px; color: #514345; text-align: justify; margin-top: 15px; border-top: 1px solid #EBE0E0; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="logo">Aelia Boutique</div>
                    <div style="font-size: 9px; color: #666;">RUC: {{ optional($company)->ruc ?? '20601234567' }}</div>
                    <div style="font-size: 9px; color: #666;">{{ optional($company)->direccion ?? 'Av. Conquistadores 789, San Isidro, Lima' }}</div>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <div style="font-size: 14px; font-weight: bold; color: #825159;">HOJA DE RECLAMACIÓN</div>
                    <div style="font-size: 12px; font-weight: bold; color: #B38B4D;">N° {{ $claimData['code'] }}</div>
                    <div style="font-size: 9px; color: #666;">Fecha: {{ $claimData['date'] }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">1. Identificación del Consumidor Reclamante</div>
    <table class="data-table">
        <tr>
            <td class="label">Nombre completo:</td>
            <td>{{ $claimData['name'] }}</td>
        </tr>
        <tr>
            <td class="label">Documento Identidad (DNI/CE/RUC):</td>
            <td>{{ $claimData['document_type'] }} - {{ $claimData['document_number'] }}</td>
        </tr>
        <tr>
            <td class="label">Teléfono / WhatsApp:</td>
            <td>{{ $claimData['phone'] }}</td>
        </tr>
        <tr>
            <td class="label">Correo Electrónico:</td>
            <td>{{ $claimData['email'] }}</td>
        </tr>
        <tr>
            <td class="label">Domicilio:</td>
            <td>{{ $claimData['address'] }}</td>
        </tr>
    </table>

    <div class="section-title">2. Identificación del Bien Contratado</div>
    <table class="data-table">
        <tr>
            <td class="label">Tipo de Bien:</td>
            <td>{{ ucfirst($claimData['contracted_type'] ?? 'Producto') }}</td>
        </tr>
        <tr>
            <td class="label">Monto Reclamado:</td>
            <td>S/ {{ number_format($claimData['amount'] ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Descripción del bien:</td>
            <td>{{ $claimData['description_good'] ?? 'Prenda / Producto Aelia Boutique' }}</td>
        </tr>
    </table>

    <div class="section-title">3. Detalle de la Reclamación y Pedido del Consumidor</div>
    <table class="data-table">
        <tr>
            <td class="label">Tipo de Registro:</td>
            <td><strong>{{ strtoupper($claimData['claim_type'] ?? 'RECLAMO') }}</strong> (Reclamo: Disconformidad relacionada a los productos / Queja: Malestar en la atención)</td>
        </tr>
    </table>

    <div style="font-weight: bold; font-size: 10px; margin-top: 6px; margin-bottom: 2px;">Detalle del Reclamo / Queja:</div>
    <div class="text-box">
        {{ $claimData['detail'] }}
    </div>

    <div style="font-weight: bold; font-size: 10px; margin-top: 6px; margin-bottom: 2px;">Pedido concreto del consumidor:</div>
    <div class="text-box">
        {{ $claimData['request'] }}
    </div>

    <div class="legal-notice">
        * Conforme a lo establecido en el Código de Protección y Defensa del Consumidor (Ley N° 29571) y el Reglamento del Libro de Reclamaciones, el proveedor deberá dar respuesta al reclamo en un plazo no mayor a quince (15) días hábiles improrrogables.<br>
        * La formulación del reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.
    </div>

</body>
</html>
