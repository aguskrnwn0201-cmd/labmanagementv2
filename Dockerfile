# Gunakan image PHP 8.2 FPM
FROM php:8.2-fpm

# Install sistem dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html


EXPOSE 9000
CMD ["php-fpm"]