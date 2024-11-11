<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barra de Navegación Mejorada</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilo de la barra de navegación */
        .navbar {
            background-color: #e3f2fd; /* Azul claro */
            transition: background-color 0.3s ease;
        }
        .navbar.scrolled {
            background-color: #007bff; /* Azul más oscuro al hacer scroll */
        }
        .navbar-brand {
            font-weight: bold;
            color: #007bff;
            transition: color 0.3s ease;
        }
        .navbar.scrolled .navbar-brand {
            color: #ffffff; /* Cambia a blanco cuando hace scroll */
        }
        .navbar-nav .nav-link {
            color: #555; /* Gris oscuro */
            font-size: 16px;
            font-weight: 500;
            padding: 10px 15px;
            transition: color 0.3s ease, background-color 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #007bff; /* Azul principal al pasar el cursor */
            background-color: #f0f8ff;
            border-radius: 5px;
        }
        /* Estilo para el botón activo */
        .navbar-nav .active {
            color: #ffffff !important;
            background-color: #007bff;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="#">Mi Proyecto Médico</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="http://localhost:8082">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#citas">Citas para Pacientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#doctores">Doctores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pago">Método de Pago</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#chat">Chat con IA</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Cambia el color de la barra de navegación al hacer scroll
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('scrolled');
        } else {
            $('.navbar').removeClass('scrolled');
        }
    });

    // Desplazamiento suave para los enlaces de la barra de navegación
    $('.nav-link').click(function(event) {
        if ($(this).attr('href').startsWith("#")) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top - 70
            }, 800);
        }

        // Cambia la clase 'active' a la opción seleccionada
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });
</script>

</body>
</html>
