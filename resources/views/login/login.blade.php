<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fritz C.A | Login</title>
    <style>
        :root {
            --fritz-red: #DC2626;
            --fritz-red-light: #EF4444;
            --fritz-black: #1A1A1A;
            --fritz-white: #FFFFFF;
            --fritz-gray: #F5F5F5;
        }
        
        body {
            background-color: var(--fritz-gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .login-header {
            background-color: var(--fritz-black);
            color: var(--fritz-white);
            padding: 1.75rem;
            text-align: center;
            position: relative;
        }
        
        .login-header h2 {
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }
        
        .welcome-text {
            color: var(--fritz-red);
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .login-body {
            padding: 2.5rem;
            background-color: var(--fritz-white);
        }
        
        .form-control {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 12px 90px;
            margin-bottom: 1.5rem;
            transition: all 0.5s;
            font-size: 15px;
        }
        
        .form-control:focus {
            border-color: var(--fritz-red);
            box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.25);
            outline: none;
        }
        
        .btn-fritz {
            background-color: var(--fritz-red);
            border: none;
            color: white;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            border-radius: 6px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            cursor: pointer;
        }
        
        .btn-fritz:hover {
            background-color: var(--fritz-red-light);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: var(--fritz-black);
            border: none;
            color: white;
            padding: 10px;
            font-weight: 600;
            width: 100%;
            border-radius: 6px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 1rem;
        }
        
        .btn-secondary:hover {
            background-color: #333;
            transform: translateY(-1px);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--fritz-black);
            margin-bottom: 0.5rem;
            display: block;
            font-size: 14px;
        }
        
        .alert {
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 1.5rem;
            border: 1px solid transparent;
            font-size: 14px;
        }
        
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        
        .logo-text {
            font-weight: 800;
            color: var(--fritz-black);
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 1.8rem;
        }
        
        .logo-text span {
            color: var(--fritz-red);
        }
        
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        
        .mt-3 {
            margin-top: 1rem;
        }
        
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>BIENVENIDO A</h2>
            <center><img src="{{asset('img/logo-fritz-web.webp')}}" alt="logoo"  style="width: 110px; height: 65px;"></center>
        </div>
        <div class="login-body">
            <div class="logo-text">
                <span>Fritz C.A</span>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- FORMULARIO CORRECTO - action apunta a la ruta POST -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Usuario</label>
                    <input type="text" style="text-align: center" name="name" id="name" class="form-control" required 
                           placeholder="Ingrese su usuario" value="{{ old('name') }}" autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" style="text-align: center" name="password" id="password" class="form-control" required 
                           placeholder="Ingrese su contraseña">
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-fritz">INGRESAR AL SISTEMA</button>
                   
                </div>
            </form>
        </div>
    </div>
</body>
</html>