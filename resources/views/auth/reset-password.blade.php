<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Restablecer Contraseña - CUP FICCT</title>
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
        .reset-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 480px;
            width: 100%;
        }
        .reset-header {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .reset-header i {
            font-size: 55px;
            margin-bottom: 15px;
        }
        .reset-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .reset-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .reset-body {
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
        .btn-reset {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            color: white;
            transition: all 0.3s;
        }
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(10, 43, 94, 0.3);
        }
        .alert {
            border-radius: 12px;
            font-size: 13px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        @media (max-width: 480px) {
            .reset-card {
                max-width: 100%;
            }
            .reset-header {
                padding: 25px 20px;
            }
            .reset-header i {
                font-size: 45px;
            }
            .reset-header h2 {
                font-size: 20px;
            }
            .reset-body {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="reset-card">
        <div class="reset-header">
            <i class="fas fa-lock-open"></i>
            <h2>Restablecer Contraseña</h2>
            <p>Ingresa tu nueva contraseña</p>
        </div>
        
        <div class="reset-body">
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

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ request()->route('token') }}">
                <input type="hidden" name="email" value="{{ request()->email }}">
                
                <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control" value="{{ request()->email }}" disabled>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nueva Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="••••••">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirmar Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••">
                    </div>
                </div>
                
                <button type="submit" class="btn-reset">
                    <i class="fas fa-save me-2"></i> Restablecer Contraseña
                </button>
            </form>
        </div>
    </div>
</body>
</html>