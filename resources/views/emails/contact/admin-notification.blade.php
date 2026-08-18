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
        .msg-box { background: #FFF8F7; padding: 15px; border-left: 4px solid #825159; border-radius: 4px; font-size: 13px; line-height: 1.6; margin-bottom: 20px; }
        .footer { text-align: center; font-size: 11px; color: #514345; margin-top: 30px; border-top: 1px solid #EBE0E0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Aelia Boutique</div>
            <p style="margin-top: 5px; font-size: 11px; color: #825159; text-transform: uppercase;">Mensaje Recibido desde Formulario de Contacto</p>
        </div>

        <div class="box">
            <strong>Remitente:</strong> {{ $contactData['name'] ?? 'Cliente' }}<br>
            <strong>Email:</strong> {{ $contactData['email'] ?? '-' }}<br>
            <strong>Teléfono:</strong> {{ $contactData['phone'] ?? 'No especificado' }}<br>
            <strong>Asunto:</strong> {{ $contactData['subject'] ?? 'Consulta General' }}
        </div>

        <div style="font-weight: bold; font-size: 13px; margin-bottom: 6px; color: #825159;">Mensaje del Cliente:</div>
        <div class="msg-box">
            {!! nl2br(e($contactData['message'] ?? '')) !!}
        </div>

        <div class="footer">
            Mensaje recibido desde el formulario de contacto web de Aelia Boutique.
        </div>
    </div>
</body>
</html>
