<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear una Cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos previamente definidos */
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
            background-image: url('{{ asset('images/img1.jpg') }}');
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        .container {
            max-width: 360px;
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

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: var(--primary);
            margin: 20px 0;
            text-align: center;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .input-group {
            position: relative;
            margin-bottom: 24px;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #E2E8F0;
            border-radius: 8px;
            background: white;
            transition: all 0.3s ease;
        }

        .input-group input:focus,
        .input-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 8px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        .input-group label {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            padding: 0 4px;
            color: #64748B;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label,
        .input-group select:focus + label,
        .input-group select:not([value=""]) + label {
            top: -10px;
            font-size: 12px;
            color: var(--primary);
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
        }

        .login-link {
            text-align: center;
            margin-top: 16px;
            color: #64748B;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="{{ asset('images/img5.png') }}" alt="Logo" class="logo">
        </div>
        <h1>Crear una Cuenta</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="input-group">
                <input type="text" id="name" name="name" required placeholder=" ">
                <label for="name">Nombre Completo</label>
            </div>
            <div class="input-group">
                <input type="email" id="email" name="email" required placeholder=" ">
                <label for="email">Correo Electrónico</label>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" required placeholder=" ">
                <label for="password">Contraseña</label>
            </div>
            <div class="input-group">
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder=" ">
                <label for="password_confirmation">Confirmar Contraseña</label>
            </div>

            <!-- Campo para seleccionar el tipo de usuario -->
            <div class="input-group">
                <select id="user_type" name="user_type" required>
                    <option value="" disabled selected>Selecciona el tipo de cuenta</option>
                    <option value="recepcionist">Recepcionista</option>
                    <option value="doctor">Doctor</option>
                </select>
                <label for="user_type">Rol en el Sistema</label>
            </div>
            
            <!-- Campo de cédula para doctor -->
            <div class="input-group" id="cedula-field" style="display: none;">
                <input type="text" id="cedula" name="cedula" placeholder=" ">
                <label for="cedula">Cédula Profesional (solo para doctores)</label>
            </div>

            <!-- Campo de especialización para doctor -->
            <div class="input-group" id="specialization-field" style="display: none;">
                <select id="specialization" name="specialization">
                    <option value="" disabled selected>Selecciona tu especialización</option>
                    <option value="Cardiología">Cardiología</option>
                    <option value="Pediatría">Pediatría</option>
                    <option value="Dermatología">Dermatología</option>
                    <option value="Neurología">Neurología</option>
                    <option value="Psiquiatría">Psiquiatría</option>
                    <option value="Ginecología">Ginecología</option>
                    <option value="Ortopedia">Ortopedia</option>
                </select>
                <label for="specialization">Especialización (solo para doctores)</label>
            </div>

            <button type="submit" class="btn-register">Registrar</button>
        </form>
        <div class="login-link">
            ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar Sesión</a>
        </div>
    </div>

    <script>
        // Mostrar campos de cédula y especialización solo cuando se selecciona "Doctor"
        document.getElementById('user_type').addEventListener('change', function() {
            var cedulaField = document.getElementById('cedula-field');
            var specializationField = document.getElementById('specialization-field');
            if (this.value === 'doctor') {
                cedulaField.style.display = 'block';
                specializationField.style.display = 'block';
            } else {
                cedulaField.style.display = 'none';
                specializationField.style.display = 'none';
            }
        });
    </script>
</body>
</html>
