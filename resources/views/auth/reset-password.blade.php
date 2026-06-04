<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUP FICCT - Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        .card {
            max-width: 450px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .card-header {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            color: white;
            text-align: center;
            border-radius: 16px 16px 0 0;
            padding: 25px;
        }
        .card-header i {
            font-size: 48px;
            margin-bottom: 12px;
        }
        .card-body {
            padding: 30px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            border: none;
            padding: 12px;
            width: 100%;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(10, 43, 94, 0.3);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <i class="fas fa-lock-open"></i>
            <h2 class="mb-0">Restablecer Contraseña</h2>
            <p class="mb-0 mt-2">Ingresa tu nueva contraseña</p>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ request()->email }}" required readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nueva Contraseña</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Restablecer Contraseña
                </button>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">← Volver al inicio de sesión</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>