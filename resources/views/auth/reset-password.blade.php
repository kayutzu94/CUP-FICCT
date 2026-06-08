<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - CUP FICCT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%); min-height: 100vh;">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg" style="max-width: 450px; width: 100%;">
            <div class="card-header bg-primary text-white text-center">
                <h4><i class="fas fa-lock-open"></i> Restablecer Contraseña</h4>
            </div>
            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ request()->route('token') }}">
                    <input type="hidden" name="email" value="{{ request()->email }}">
                    
                    <div class="mb-3">
                        <label>Correo Electrónico</label>
                        <input type="email" class="form-control" value="{{ request()->email }}" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label>Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    
                    <div class="mb-3">
                        <label>Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Restablecer Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>