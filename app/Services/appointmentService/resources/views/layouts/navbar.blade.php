<!-- resources/views/layouts/navbar.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 80px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .navbar {
            background-color: #e3f2fd;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar.scrolled {
            background-color: #007bff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .navbar-brand {
            font-weight: bold;
            color: #007bff;
            transition: color 0.3s ease;
            padding: 0.5rem 1rem;
        }
        .navbar.scrolled .navbar-brand {
            color: #ffffff;
        }
        .navbar-nav .nav-link {
            color: #555;
            font-size: 16px;
            font-weight: 600;
            padding: 10px 15px;
            margin: 0 2px;
            transition: all 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #007bff;
            background-color: #f0f8ff;
            border-radius: 5px;
            transform: translateY(-1px);
        }
        .navbar-nav .active {
            color: #ffffff !important;
            background-color: #0c253f;
            border-radius: 5px;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-top: 10px;
        }
        .dropdown-item {
            padding: 8px 20px;
            transition: all 0.2s ease;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }

        /* Modo oscuro */
        body.dark-mode {
            background-color: #1a1a1a;
            color: #ffffff;
        }
        .dark-mode .navbar {
            background-color: #333333;
        }
        .dark-mode .navbar.scrolled {
            background-color: #0056b3;
        }
        .dark-mode .navbar-brand {
            color: #ffffff;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        .dark-mode .navbar-nav .nav-link {
            color: #e4e4e4;
        }
        .dark-mode .navbar-nav .nav-link:hover {
            color: #ffffff;
            background-color: #4a4a4a;
        }
        .dark-mode .navbar-nav .active {
            background-color: #0066cc;
        }
        .dark-mode .dropdown-menu {
            background-color: #333333;
            border: 1px solid #444444;
        }
        .dark-mode .dropdown-item {
            color: #ffffff;
        }
        .dark-mode .dropdown-item:hover {
            background-color: #444444;
            color: #007bff;
        }
        .dark-mode .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.5)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        #darkModeToggle {
            padding: 8px 15px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        #darkModeToggle:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .dark-mode #darkModeToggle {
            color: #fff;
            border-color: #fff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="http://localhost:8082">Mi Proyecto Médico</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="http://localhost:8082">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost:8082/appointments">Citas para Pacientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost:8082/doctors">Doctores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost:8082/payment">Método de Pago</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost:8082/chat">Chat con IA</a>
                    </li>
                    @if(auth()->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="http://localhost:8082/profile">Profile</a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="http://localhost:8082/logout">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="http://localhost:8082/login">Login</a>
                        </li>
                    @endif
                    <li class="nav-item ml-2">
                        <button id="darkModeToggle" class="btn btn-outline-primary">Modo Oscuro</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.navbar').addClass('scrolled');
            } else {
                $('.navbar').removeClass('scrolled');
            }
        });

        $('.nav-link').click(function(event) {
            if ($(this).attr('href').startsWith("#")) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top - 70
                }, 800);
            }
            
            if (!$(this).hasClass('dropdown-toggle')) {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            }
        });

        if (localStorage.getItem('darkMode') === 'enabled') {
            $('body').addClass('dark-mode');
            $('#darkModeToggle').text('Modo Claro');
        }

        $('#darkModeToggle').click(function() {
            $('body').toggleClass('dark-mode');
            if ($('body').hasClass('dark-mode')) {
                $(this).text('Modo Claro');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                $(this).text('Modo Oscuro');
                localStorage.setItem('darkMode', 'disabled');
            }
        });
    </script>
</body>
</html>