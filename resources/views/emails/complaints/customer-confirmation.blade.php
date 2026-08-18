<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #FAF5F5; color: #1F1A1B; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #EBE0E0; }
        .header { text-align: center; border-bottom: 2px solid #825159; padding-bottom: 15px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #825159; font-family: Georgia, serif; }
        .box { background: #FAF5F5; border-radius: 8px; padding: 15px; margin-bottom: 20px; font-size: 13px; border: 1px solid #EBE0E0; }
        .footer { text-align: center; font-size: 11px; color: #514345; margin-top: 30px; border-top: 1px solid #EBE0E0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Aelia Boutique</div>
            <p style="margin-top: 5px; font-size: 11px; color: #B38B4D; text-transform: uppercase; letter-spacing: 1px;">Libro de Reclamaciones Virtual</p>
        </div>

        <h3 style="color: #825159; margin-top: 0;">Estimado(a) {{ $claimData['name'] }},</h3>
        <p style="font-size: 13px; line-height: 1.6;">
            Confirmamos el registro de tu atención en nuestro Libro de Reclamaciones Virtual. Adjunto a este correo encontrarás la <strong>Hoja de Reclamación en formato PDF</strong>.
        </p>

        <div class="box">
            <strong>Código de Registro:</strong> <span style="color: #825159; font-weight: bold; font-size: 14px;">{{ $claimData['code'] }}</span><br>
            <strong>Fecha de Registro:</strong> {{ $claimData['date'] }}<br>
            <strong>Tipo de Registro:</strong> {{ strtoupper($claimData['claim_type'] ?? 'RECLAMO') }}<br>
            <strong>Consumidor:</strong> {{ $claimData['name'] }} ({{ $claimData['document_type'] }}: {{ $claimData['document_number'] }})
        </div>

        <div style="background: #FFF8F7; border: 1px solid #B38B4D; padding: 12px; border-radius: 6px; font-size: 12px; color: #514345; margin-bottom: 20px;">
            ℹ️ Conforme a la normativa vigente de INDECOPI (Ley N° 29571), nuestro equipo atenderá y brindará respuesta a tu requerimiento dentro del plazo legal de quince (15) días hábiles.
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Aelia Boutique. Todos los derechos reservados.<br>
            {{ optional($company)->direccion ?? 'San Isidro, Lima - Perú' }}
        </div>
    </div>
</body>
</html>
