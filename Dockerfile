FROM php:8.2-apache

# Install system deps + ZIP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Fix Apache MPM (INI PENTING)
RUN a2dismod mpm_event || true \
    && a2dismod mpm_worker || true \
    && a2enmod mpm_prefork rewrite

# Install Composer (PASTI ADA)
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Permission Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Install PHP deps (ZIP SUDAH AKTIF)
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80
