<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CUP FICCT - Recuperar Contraseña</title>
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
            padding: 20px;
        }
        
        .recover-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 420px;
            width: 100%;
        }
        
        .recover-header {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            color: white;
            padding: 35px 30px;
            text-align: center;
        }
        
        .recover-header i {
            font-size: 55px;
            margin-bottom: 15px;
        }
        
        .recover-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        
        .recover-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        
        .recover-body {
            padding: 35px 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
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
            padding: 12px 15px;
        }
        
        .input-group-text i {
            font-size: 16px;
            color: #1a4a8a;
        }
        
        .form-control {
            border-radius: 0 12px 12px 0;
            border: 1px solid #e0e6ed;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #1a4a8a;
            box-shadow: 0 0 0 3px rgba(26, 74, 138, 0.1);
            outline: none;
        }
        
        .btn-send {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 15px;
            width: 100%;
            color: white;
            transition: all 0.3s;
        }
        
        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(10, 43, 94, 0.3);
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #1a4a8a;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 12px;
            font-size: 13px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 480px) {
            .recover-card {
                max-width: 100%;
            }
            .recover-header {
                padding: 25px 20px;
            }
            .recover-header i {
                font-size: 45px;
            }
            .recover-header h2 {
                font-size: 22px;
            }
            .recover-body {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="recover-card">
        <div class="recover-header">
            <i class="fas fa-key"></i>
            <h2>Recuperar Contraseña</h2>
            <p>Te enviaremos un enlace a tu correo</p>
        </div>
        
        <div class="recover-body">
            @if(session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control" 
                               placeholder="admin@cup.com" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                
                <button type="submit" class="btn-send">
                    <i class="fas fa-paper-plane me-2"></i> Enviar Enlace
                </button>
                
                <div class="back-link">
                    <a href="{{ route('login') }}">
                        <i class="fas fa-arrow-left me-1"></i> Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>