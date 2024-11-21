#!/bin/bash
set -e

# Establecer la zona horaria, útil para los logs y otras operaciones de fecha/hora
export TZ=UTC

echo "Configurando el entorno Laravel..."

# Generar key de Laravel si no existe
if [ ! -f .env ]; then
    echo "Archivo .env no encontrado, copiando de .env.example..."
    cp .env.example .env
    php artisan key:generate
    echo "Key de Laravel generada."
fi

# Esperar a que la base de datos esté disponible
echo "Esperando por la conexión de la base de datos en ${DB_HOST}..."
until nc -z -v -w30 $DB_HOST 3306; do
  echo "Reintentando en 5 segundos..."
  sleep 5
done
echo "Base de datos conectada."

# Ejecutar migraciones si es necesario
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    echo "Ejecutando migraciones..."
    php artisan migrate --force
    echo "Migraciones completadas."
fi

# Limpiar y optimizar Laravel
echo "Optimizando la aplicación..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize
echo "Optimización completa."

# Asegurar permisos correctos
echo "Asegurando permisos correctos para directorios..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "Iniciando el servidor web..."
# Ejecutar el comando original (permite que este script sea utilizado como un punto de entrada para el contenedor)
exec "$@"
