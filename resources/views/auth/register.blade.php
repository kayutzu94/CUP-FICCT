<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CUP FICCT - Registrarse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        
        body {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .register-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 480px;
            width: 100%;
        }
        
        .register-header {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            color: white;
            padding: 30px 25px;
            text-align: center;
        }
        
        .register-header i {
            font-size: 50px;
            margin-bottom: 12px;
        }
        
        .register-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        
        .register-header p {
            margin: 8px 0 0;
            opacity: 0.85;
            font-size: 13px;
        }
        
        .register-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 18px;
        }
        
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
            display: block;
        }
        
        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-group-text {
            background: #f8f9fc;
            border: 1px solid #e0e6ed;
            border-right: none;
            border-radius: 12px 0 0 12px;
            padding: 10px 14px;
        }
        
        .input-group-text i {
            font-size: 14px;
            color: #1a4a8a;
        }
        
        .form-control {
            border-radius: 0 12px 12px 0;
            border: 1px solid #e0e6ed;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #1a4a8a;
            box-shadow: 0 0 0 3px rgba(26, 74, 138, 0.1);
            outline: none;
        }
        
        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            color: #adb5bd;
            z-index: 10;
            font-size: 14px;
        }
        
        .password-toggle:hover { color: #1a4a8a; }
        
        .btn-register {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            color: white;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(10, 43, 94, 0.3);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eef2f7;
        }
        
        .login-link a {
            color: #1a4a8a;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        
        .login-link a:hover { text-decoration: underline; }
        
        .alert {
            border-radius: 12px;
            font-size: 12px;
            padding: 10px 14px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 480px) {
            .register-card { max-width: 100%; }
            .register-header { padding: 25px 20px; }
            .register-header i { font-size: 42px; }
            .register-header h2 { font-size: 20px; }
            .register-body { padding: 25px 20px; }
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h2>Crear Cuenta</h2>
            <p>Regístrate como Docente</p>
        </div>
        
        <div class="register-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Nombre Completo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Ej: Juan Pérez" value="{{ old('name') }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" value="{{ old('email') }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••" required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirmar Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus me-2"></i> Registrarse
                </button>
                
                <div class="login-link">
                    <a href="{{ route('login') }}">
                        <i class="fas fa-arrow-left me-1"></i> ¿Ya tienes cuenta? Inicia sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>