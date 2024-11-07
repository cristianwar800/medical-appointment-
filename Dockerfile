# Usar la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instalar las extensiones necesarias de PHP
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        vim \
    && docker-php-ext-install pdo_mysql mysqli gd

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Configurar ServerName para evitar el mensaje de advertencia de Apache
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# Copiar la aplicación
COPY . /var/www/html

# Configurar permisos adecuados para los directorios de Laravel
# Importante: Para evitar problemas de permisos en `storage` y `bootstrap/cache`, utiliza 775 en lugar de 755.
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Configurar el DocumentRoot para apuntar al directorio 'public' de Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
