<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Plataforma Médica</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        :root {
            --primary: #4F46E5;
            --secondary: #06B6D4;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: url('{{ asset('images/img1.jpg') }}'); /* Asegúrate de que la ruta sea correcta */
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        .container {
            max-width: 320px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .avatar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .avatar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            color: var(--primary);
            text-align: center;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        input[type="email"], input[type="password"], input[type="checkbox"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #E2E8F0;
            border-radius: 8px;
            background: white;
            font-size: 16px;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: var(--primary);
            box-shadow: 0 0 8px rgba(79, 70, 229, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #64748B;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
        }

        .footer-link {
            text-align: center;
            font-size: 14px;
            margin-top: 15px;
        }

        .footer-link a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-link a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        .error {
            color: #EF4444;
            font-size: 12px;
            margin-top: -8px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="avatar">
            <img src="{{ asset('images/img5.png') }}" alt="Logo" class="logo"> <!-- Asegúrate de que la ruta del logo sea correcta -->
        </div>
        <h2>Iniciar Sesión</h2>
        
        <!-- Estado de la Sesión -->
        @if (session('status'))
            <div class="error">{{ session('status') }}</div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Correo Electrónico -->
            <div>
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Recordarme -->
            <div>
                <label for="remember_me">
                    <input type="checkbox" id="remember_me" name="remember"> Recordarme
                </label>
            </div>

            <button type="submit">Iniciar Sesión</button>

            <!-- Enlace para recuperar la contraseña -->
            <div class="footer-link">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

            <!-- Enlace para registrarse -->
            <div class="footer-link">
                ¿No tienes una cuenta? <a href="{{ route('register') }}">Crea tu cuenta</a>
            </div>
        </form>
    </div>
</body>
</html>
