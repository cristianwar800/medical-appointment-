# 🏥 Sistema de Citas Médicas

¡Bienvenido al **Sistema de Citas Médicas**! Este proyecto está diseñado para proporcionar una forma sencilla de gestionar citas médicas. 🚑💻 A continuación, encontrarás los detalles sobre cómo empezar, incluyendo requisitos, instrucciones de configuración y cómo ejecutar el proyecto localmente.

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Primeros Pasos](#-primeros-pasos)
- [Instalación](#-instalación)
- [Uso](#-uso)
- [Capturas de Pantalla](#-capturas-de-pantalla)
- [Contribuir](#-contribuir)
- [Licencia](#-licencia)

## ✨ Características

- 🗓️ Programación y gestión de citas.
- 👩‍⚕️ Gestión de detalles de doctores y pacientes.
- 📊 Panel con información resumida.
- 📱 Diseño responsivo para móvil y escritorio.

## 🚀 Primeros Pasos

Para obtener una copia de este proyecto y ejecutarlo en tu máquina local, sigue estos sencillos pasos.

### ✅ Requisitos Previos

- Tener instalado [Docker](https://www.docker.com/get-started).
- Tener instalado [Composer](https://getcomposer.org/download/).
- Tener instalado [Node.js & npm](https://nodejs.org/en/download/).

### 📥 Instalación

1. **Clonar el repositorio**
   
   ```bash
   git clone https://github.com/tu-usuario/medical-appointment-system.git
   cd medical-appointment-system
   ```

2. **Copiar el archivo de entorno**
   
   ```bash
   cp .env.example .env
   ```

3. **Instalar dependencias**
   
   ```bash
   composer install
   npm install
   ```

4. **Generar la clave de la aplicación**
   
   ```bash
   php artisan key:generate
   ```

5. **Configurar Docker**
   
   Asegúrate de que Docker esté en ejecución, luego construye e inicia los contenedores:
   
   ```bash
   docker-compose up -d
   ```

### ⚙️ Ejecutar la Aplicación

1. **Migrar la base de datos**
   
   ```bash
   php artisan migrate
   ```

2. **Servir la aplicación**
   
   ```bash
   php artisan serve
   ```

3. **Acceder a la aplicación**
   
   Abre tu navegador y ve a [http://localhost:8000](http://localhost:8000).

## 📸 Capturas de Pantalla

A continuación, algunas capturas de pantalla de la aplicación en acción:

### Página Principal Welcome
![image](https://github.com/user-attachments/assets/422f41e8-2703-41e5-a3a9-3be2ae4e667d)

### Login

![image](https://github.com/user-attachments/assets/b7800bde-34c7-4832-878f-5207832f5e98)

### Register
![image](https://github.com/user-attachments/assets/1b65292c-ca4e-4352-b6d4-0da3be3b8850)

### Home
![image](https://github.com/user-attachments/assets/583b182d-ba9c-495a-b2ce-a6cf15cf8e12)
![image](https://github.com/user-attachments/assets/6822d6fd-ea28-41e0-8bf4-40f50db1a178)
![image](https://github.com/user-attachments/assets/f1cb30c8-68fc-4b74-b5d5-22c31842e858)
![image](https://github.com/user-attachments/assets/59a50692-9dc0-4ad8-b24a-fcaeefd5d3d5)

### Crud de citas
![Imagen de WhatsApp 2024-11-10 a las 23 52 55_de5d6d1d](https://github.com/user-attachments/assets/bd6a2d26-b08e-4e12-90d8-affb7bf1adee)

### Kubernetes
![kubernetes](https://github.com/user-attachments/assets/f9735958-edcd-41c1-a7e1-453117990fcf)

### ChatBot
![chatbot](https://github.com/user-attachments/assets/c496778b-2143-4127-9c81-5928300391e1)
![chatbot2](https://github.com/user-attachments/assets/5e9848f6-ac15-4687-a029-c032d91a89fc)

### Istio
![cd417483-915b-42b0-a827-207ff785f747](https://github.com/user-attachments/assets/8b0472ec-6ca8-4c2f-bb8e-a448287b41ec)
![44 (1)](https://github.com/user-attachments/assets/55b4021d-e4db-42f3-8b97-c48b06f92bd9)
![image](https://github.com/user-attachments/assets/8dc614ec-6cf5-468f-b303-53a83fc1e699)




### The Chaos
![1](https://github.com/user-attachments/assets/5e6113bd-c20c-463b-a493-062ad5c84e44)
![2](https://github.com/user-attachments/assets/8003ef67-88a1-4958-aa76-8c7359cee1e4)
![3](https://github.com/user-attachments/assets/b7af5f74-92cd-426a-a5e4-61ffb78ccf1b)
![4](https://github.com/user-attachments/assets/ab83237e-3a9b-404c-be63-ba25ba711295)
![5](https://github.com/user-attachments/assets/08cddb6e-a293-4924-a9f2-92976bf9fec5)
![6](https://github.com/user-attachments/assets/068df6e2-65fa-4150-966c-8ff3079fd40c)




¡Damos la bienvenida a las contribuciones! Por favor, sigue estos pasos para contribuir:

1. **Haz un fork del repositorio**
2. **Crea una nueva rama** (`git checkout -b feature/TuCaracterística`)
3. **Confirma tus cambios** (`git commit -m 'Agregar alguna característica'`)
4. **Haz push a la rama** (`git push origin feature/TuCaracterística`)
5. **Crea un Pull Request**

## 📜 Licencia

Este proyecto está bajo la Licencia MIT - consulta el archivo [LICENSE](LICENSE) para más detalles.

---

🚀 Hecho con ❤️ por Romina Jacqueline Aguirre Velazco, Cristian Lopez Rosales, Diego Rafael Maldonado Mendoza


