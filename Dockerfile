# Usar imagen base optimizada
FROM php:8.1-apache

# Instalar dependencias y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    vim \
    && docker-php-ext-install pdo_mysql mysqli gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && a2enmod rewrite

# Habilitar y configurar Opcache
RUN docker-php-ext-install opcache
COPY opcache.ini $PHP_INI_DIR/conf.d/

# Copiar el directorio público a DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copiar la aplicación
COPY . /var/www/html

# Configurar permisos adecuados para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 664 {} \; \
    && find /var/www/html -type d -exec chmod 775 {} \;

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
