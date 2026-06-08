<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recuperar Contraseña</title>
</head>
<body>
    <h2>Recuperación de Contraseña - CUP FICCT</h2>
    <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
    <a href="{{ url('/reset-password/' . $token . '?email=' . urlencode($email)) }}">
        {{ url('/reset-password/' . $token . '?email=' . urlencode($email)) }}
    </a>
    <p>Este enlace expirará en 60 minutos.</p>
    <p>Si no solicitaste este cambio, ignora este mensaje.</p>
</body>
</html>