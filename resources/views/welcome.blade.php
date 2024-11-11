<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Citas Médicas Premium</title>
    <style>
        /* Estilos básicos y colores */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        
        /* Cabecera */
        header {
            background-color: #007acc;
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://source.unsplash.com/1600x900/?medical') no-repeat center center/cover;
            opacity: 0.2;
            z-index: 0;
        }
        header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        header p {
            font-size: 1.2rem;
            position: relative;
            z-index: 1;
        }

        /* Menú de navegación */
        nav {
            display: flex;
            justify-content: center;
            background-color: #005fa3;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        nav a {
            color: white;
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
            border-radius: 5px;
            transition: all 0.3s;
        }
        nav a:hover, nav a.active {
            background-color: #007acc;
            transform: translateY(-3px);
        }

        /* Sección principal */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            text-align: center;
        }

        .welcome-section {
            background-color: #e3f2fd;
            padding: 3rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .welcome-section:hover {
            transform: translateY(-5px);
        }
        .welcome-content {
            flex: 1;
            text-align: left;
            padding-right: 2rem;
        }
        .welcome-image {
            flex: 1;
            max-width: 50%;
        }
        .welcome-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .welcome-section h2 {
            font-size: 2.2rem;
            color: #005fa3;
            margin-bottom: 1rem;
        }
        .welcome-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background-color: #007acc;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            margin-top: 1rem;
            display: inline-block;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-primary:hover {
            background-color: #005fa3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Sección de servicios */
        .services-section {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 2rem;
        }
        .service {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: calc(33% - 2rem);
            min-width: 280px;
            transition: all 0.3s;
            cursor: pointer;
        }
        .service:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .service h3 {
            color: #005fa3;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }
        .service p {
            color: #666;
            font-size: 1rem;
        }
        .service-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #007acc;
        }
        .services-image {
            width: 100%;
            max-width: 600px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
        }

        /* Sección de contacto */
        .contact-section {
            background-color: #f3f3f3;
            padding: 3rem;
            border-radius: 8px;
            margin-top: 2rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .contact-section h3 {
            color: #005fa3;
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }
        .contact-section form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
        .contact-section input, .contact-section textarea {
            width: 100%;
            max-width: 500px;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .contact-section input:focus, .contact-section textarea:focus {
            border-color: #007acc;
            outline: none;
        }
        .contact-section .btn-submit {
            background-color: #007acc;
            color: white;
            padding: 1rem 2rem;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
        }
        .contact-section .btn-submit:hover {
            background-color: #005fa3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Pie de página */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
        .social-icons {
            margin-top: 1rem;
        }
        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin: 0 0.5rem;
            transition: color 0.3s;
        }
        .social-icons a:hover {
            color: #007acc;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: #000;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .services-section {
                flex-direction: column;
            }
            .service {
                width: 100%;
            }
            nav {
                flex-wrap: wrap;
            }
            nav a {
                margin-bottom: 0.5rem;
            }
            .welcome-section {
                flex-direction: column;
            }
            .welcome-content, .welcome-image {
                max-width: 100%;
                padding-right: 0;
            }
            .welcome-image {
                margin-top: 2rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <!-- Cabecera -->
    <header>
        <h1>Centro de Citas Médicas Premium</h1>
        <p>Atención de calidad, tecnología avanzada y cuidado personalizado.</p>
    </header>

   <!-- Contenedor Principal -->
    <div class="container">
        
        <!-- Sección de Bienvenida -->
<!-- Sección de Bienvenida -->
<section id="welcome" class="welcome-section">
    <div class="welcome-content">
        <h2>Bienvenido a Nuestra Clínica Premium</h2>
        <p>En nuestro centro médico de vanguardia, nos dedicamos a proporcionar atención de la más alta calidad para cada uno de nuestros pacientes. Con nuestro avanzado sistema de citas, puedes gestionar tus consultas con facilidad y recibir el cuidado personalizado que mereces.</p>
        
        <!-- Botones de Iniciar Sesión y Registrarse -->
        <div class="button-group">
            <a href="{{ route('login') }}" class="btn-primary">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="btn-primary">Registrarse</a>
        </div>
    </div>
    <div class="welcome-image">
        <img src="{{ asset('images/img6.jpg') }}" alt="Equipo médico atendiendo a un paciente" />
    </div>
</section>


        <!-- Sección de Servicios -->
        <section id="services" class="services-section">
            <div class="service" onclick="showServiceDetails('Consulta General')">
                <i class="fas fa-user-md service-icon"></i>
                <h3>Consulta General</h3>
                <p>Accede a servicios de consulta general con profesionales de élite, listos para atenderte en cualquier momento.</p>
            </div>
            <div class="service" onclick="showServiceDetails('Especialidades Médicas')">
                <i class="fas fa-stethoscope service-icon"></i>
                <h3>Especialidades Médicas</h3>
                <p>Encuentra al especialista adecuado según tus necesidades: cardiología, pediatría, ginecología y mucho más.</p>
            </div>
            <div class="service" onclick="showServiceDetails('Pruebas y Diagnósticos')">
                <i class="fas fa-microscope service-icon"></i>
                <h3>Pruebas y Diagnósticos</h3>
                <p>Ofrecemos servicios completos de diagnóstico con tecnología de punta para resultados rápidos y precisos.</p>
            </div>
        </section>
        
        <img src="images/img7.jpg" alt="Instalaciones médicas modernas" class="services-image" />

        <!-- Sección de Contacto -->
        <section id="contact" class="contact-section">
            <h3>Contáctanos</h3>
            <form id="contact-form">
                <input type="text" name="name" placeholder="Tu Nombre" required>
                <input type="email" name="email" placeholder="Tu Email" required>
                <textarea name="message" rows="4" placeholder="Escribe tu mensaje..." required></textarea>
                <button type="submit" class="btn-submit">Enviar Mensaje</button>
            </form>
        </section>
    </div>

    <!-- Modal para programar cita -->
    <div id="appointmentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Programar una Cita</h2>
            <form id="appointment-form">
                <input type="text" placeholder="Nombre completo" required>
                <input type="email" placeholder="Correo electrónico" required>
                <input type="tel" placeholder="Teléfono" required>
                <input type="date" required>
                <select required>
                    <option value="">Seleccione el servicio</option>
                    <option value="general">Consulta General</option>
                    <option value="especialidad">Especialidad Médica</option>
                    <option value="diagnostico">Pruebas y Diagnósticos</option>
                </select>
                <button type="submit" class="btn-primary">Confirmar Cita</button>
            </form>
        </div>
    </div>

    <!-- Modal para detalles del servicio -->
    <div id="serviceModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="serviceTitle"></h2>
            <p id="serviceDescription"></p>
        </div>
    </div>

    <!-- Pie de página -->
    <footer>
        <p>© 2024 Centro de Citas Médicas Premium. Todos los derechos reservados.</p>
        <div class="social-icons">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
        </div>
    </footer>

    <script>
        // Navegación suave
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Resaltar enlace de navegación activo
        window.addEventListener('scroll', () => {
            let current = '';
            document.querySelectorAll('section').forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 60) {
                    current = section.getAttribute('id');
                }
            });

            document.querySelectorAll('#main-nav a').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').substring(1) === current) {
                    link.classList.add('active');
                }
            });
        });

        // Modal de cita
        const modal = document.getElementById("appointmentModal");
        const btn = document.getElementById("openModal");
        const span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Formulario de cita
        document.getElementById('appointment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('¡Gracias por programar tu cita! Te contactaremos pronto para confirmar los detalles.');
            modal.style.display = "none";
        });

        // Formulario de contacto
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('¡Gracias por tu mensaje! Te responderemos lo antes posible.');
            this.reset();
        });

        // Modal de servicios
        const serviceModal = document.getElementById("serviceModal");
        const serviceTitle = document.getElementById("serviceTitle");
        const serviceDescription = document.getElementById("serviceDescription");

        function showServiceDetails(service) {
            serviceTitle.textContent = service;
            switch(service) {
                case 'Consulta General':
                    serviceDescription.textContent = 'Nuestro servicio de consulta general ofrece atención médica integral para pacientes de todas las edades. Nuestros médicos altamente calificados están disponibles para abordar una amplia gama de problemas de salud, desde chequeos de rutina hasta el manejo de condiciones crónicas.';
                    break;
                case 'Especialidades Médicas':
                    serviceDescription.textContent = 'Contamos con un equipo de especialistas en diversas áreas médicas, incluyendo cardiología, neurología, pediatría, ginecología, y más. Nuestros expertos utilizan las técnicas más avanzadas para proporcionar un cuidado especializado y personalizado.';
                    break;
                case 'Pruebas y Diagnósticos':
                    serviceDescription.textContent = 'Nuestro centro está equipado con tecnología de vanguardia para realizar una amplia gama de pruebas diagnósticas. Desde análisis de laboratorio hasta imágenes avanzadas, ofrecemos resultados rápidos y precisos para facilitar un diagnóstico y tratamiento efectivos.';
                    break;
            }
            serviceModal.style.display = "block";
        }

        // Cerrar modal de servicios
        serviceModal.querySelector('.close').onclick = function() {
            serviceModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == serviceModal) {
                serviceModal.style.display = "none";
            }
        }
    </script>
</body>
</html>