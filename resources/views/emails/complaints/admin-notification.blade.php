<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF5F5; color: #1F1A1B; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #EBE0E0; }
        .header { text-align: center; border-bottom: 2px solid #825159; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #825159; font-family: Georgia, serif; }
        .alert-badge { background: #dc2626; color: #ffffff; padding: 6px 16px; font-size: 12px; font-weight: bold; border-radius: 20px; text-transform: uppercase; display: inline-block; }
        .box { background: #FAF5F5; border-radius: 8px; padding: 15px; margin-bottom: 20px; font-size: 13px; border: 1px solid #EBE0E0; }
        .text-detail { background: #FFF8F7; padding: 10px; border: 1px solid #EBE0E0; border-radius: 6px; font-size: 12px; margin-bottom: 15px; }
        .footer { text-align: center; font-size: 11px; color: #514345; margin-top: 30px; border-top: 1px solid #EBE0E0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Aelia Boutique</div>
            <p style="margin-top: 5px; font-size: 11px; color: #dc2626; text-transform: uppercase;">Atención al Cliente - Libro de Reclamaciones</p>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <span class="alert-badge">⚠️ Nuevo Reclamo / Queja Registrada</span>
        </div>

        <div class="box">
            <strong>Código de Registro:</strong> <span style="font-size: 15px; font-weight: bold; color: #dc2626;">{{ $claimData['code'] }}</span><br>
            <strong>Fecha:</strong> {{ $claimData['date'] }}<br>
            <strong>Tipo de Registro:</strong> {{ strtoupper($claimData['claim_type'] ?? 'RECLAMO') }}<br>
            <strong>Consumidor:</strong> {{ $claimData['name'] }}<br>
            <strong>Documento:</strong> {{ $claimData['document_type'] }}: {{ $claimData['document_number'] }}<br>
            <strong>Teléfono:</strong> {{ $claimData['phone'] }}<br>
            <strong>Email:</strong> {{ $claimData['email'] }}<br>
            <strong>Dirección:</strong> {{ $claimData['address'] }}
        </div>

        <div style="font-weight: bold; font-size: 12px; margin-bottom: 4px;">Detalle del Reclamo / Queja:</div>
        <div class="text-detail">
            {{ $claimData['detail'] }}
        </div>

        <div style="font-weight: bold; font-size: 12px; margin-bottom: 4px;">Pedido Concreto del Consumidor:</div>
        <div class="text-detail">
            {{ $claimData['request'] }}
        </div>

        <div class="footer">
            Atención: Recuerde que el plazo máximo legal para responder a este reclamo es de 15 días hábiles.
        </div>
    </div>
</body>
</html>
