<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - CUP FICCT</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background: linear-gradient(135deg, #1a4a8a 0%, #0a2b5e 100%);
        }
        .footer {
            background: #f8f9fc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            font-size: 13px;
            border-radius: 5px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 80px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="{{ asset('images/Escudo_FICCT.png') }}" alt="Escudo FICCT" style="max-width: 60px;">
            </div>
            <h1>CUP FICCT</h1>
            <p>Curso Preuniversitario - Facultad FICCT</p>
        </div>
        
        <div class="content">
            <h2>¡Hola!</h2>
            <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en el <strong>Sistema de Admisión Universitaria CUP FICCT</strong>.</p>
            
            <p>Para continuar con el proceso, haz clic en el siguiente botón:</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/reset-password/' . $token . '?email=' . urlencode($email)) }}" class="button">
                    🔐 Restablecer Contraseña
                </a>
            </div>
            
            <p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
            <p style="word-break: break-all; font-size: 12px; background: #f4f4f4; padding: 10px; border-radius: 5px;">
                {{ url('/reset-password/' . $token . '?email=' . urlencode($email)) }}
            </p>
            
            <div class="warning">
                <strong>⚠️ Importante:</strong>
                <ul style="margin: 10px 0 0 20px;">
                    <li>Este enlace expirará en <strong>60 minutos</strong>.</li>
                    <li>Si no solicitaste este cambio, ignora este mensaje.</li>
                    <li>Tu contraseña no cambiará hasta que accedas al enlace.</li>
                </ul>
            </div>
            
            <p>Saludos cordiales,<br>
            <strong>Equipo de Administración<br>CUP FICCT - UAGRM</strong></p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sistema de Admisión Universitaria - Facultad FICCT</p>
            <p>Universidad Autónoma Gabriel René Moreno - Santa Cruz - Bolivia</p>
            <p style="font-size: 11px;">Este es un correo automático, por favor no responder.</p>
        </div>
    </div>
</body>
</html>