<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CUP FICCT - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        
        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        
        .login-header {
            background: white;
            padding: 30px 24px 20px;
            text-align: center;
            border-bottom: 1px solid #eef2f7;
        }
        
        .logo-placeholder {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        
        .logo-placeholder i {
            font-size: 40px;
            color: white;
        }
        
        .login-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            color: #0a2b5e;
        }
        
        .login-header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #6c757d;
        }
        
        .badge-ficct {
            background: #eef2ff;
            color: #1a4a8a;
            font-size: 10px;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 8px;
        }
        
        .login-body {
            padding: 24px;
        }
        
        .form-group {
            margin-bottom: 20px;
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
        
        .password-toggle:hover {
            color: #1a4a8a;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            color: white;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(10, 43, 94, 0.25);
        }
        
        .form-check {
            margin: 16px 0;
        }
        
        .form-check-label {
            font-size: 12px;
            color: #555;
        }
        
        .forgot-link {
            text-align: center;
            margin-top: 16px;
        }
        
        .forgot-link a {
            color: #1a4a8a;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
        }
        
        .forgot-link a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 12px;
            font-size: 12px;
            padding: 10px 14px;
            margin-bottom: 20px;
        }
        
        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #adb5bd;
            border-top: 1px solid #eef2f7;
            padding-top: 16px;
        }
        
        @media (max-width: 480px) {
            .login-card {
                max-width: 100%;
            }
            .login-header {
                padding: 24px 20px 16px;
            }
            .logo-placeholder {
                width: 65px;
                height: 65px;
            }
            .logo-placeholder i {
                font-size: 32px;
            }
            .login-header h2 {
                font-size: 20px;
            }
            .login-body {
                padding: 20px;
            }
            .form-group {
                margin-bottom: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="logo-placeholder">
                <i class="fas fa-laptop-code"></i>
            </div>
            <h2>CUP FICCT</h2>
            <p>Curso Preuniversitario</p>
            <div class="badge-ficct">
                <i class="fas fa-check-circle me-1"></i> Admisión 2026
            </div>
        </div>
        
        <div class="login-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="admin@cup.com" value="{{ old('email', 'admin@cup.com') }}" required autofocus>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                               placeholder="••••••" value="admin123" required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-arrow-right-to-bracket me-2"></i> Ingresar
                </button>
                
                <div class="forgot-link">
                    <a href="{{ route('password.request') }}">
                        <i class="fas fa-key me-1"></i> ¿Olvidaste tu contraseña?
                            <div class="register-link" style="text-align: center; margin-top: 15px;">
                                <a href="{{ route('register') }}" style="color: #1a4a8a; text-decoration: none; font-size: 13px;">
                                    <i class="fas fa-user-plus me-1"></i> ¿No tienes cuenta? Regístrate
                                </a>
                            </div>
                    </a>
                </div>
            </form>
        </div>
        
        <div class="footer-text">
            <i class="fas fa-graduation-cap me-1"></i> Facultad FICCT - UAGRM
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