FROM php:8.1-apache

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

RUN docker-php-ext-install opcache
COPY ../../docker/opcache.ini $PHP_INI_DIR/conf.d/

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY ../../app/Services/chatbot-service .

RUN chown -R www-data:www-data . \
    && find . -type f -exec chmod 664 {} \; \
    && find . -type d -exec chmod 775 {} \;

EXPOSE 80
CMD ["apache2-foreground"]