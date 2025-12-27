FROM php:8.2-apache

# Install dependency
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Apache config
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork rewrite

WORKDIR /var/www/html
COPY . .

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

EXPOSE 80
