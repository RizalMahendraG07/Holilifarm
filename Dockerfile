# Gunakan image PHP dasar
FROM php:8.2-fpm

# Install ekstensi dan tools yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Install Composer dari official composer image
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory (wajib cocok dengan docker-compose volume mount)
WORKDIR /var/www
COPY src/ /var/www/html/
