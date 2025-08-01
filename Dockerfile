FROM php:8.4-apache

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    unzip \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev && \
    docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install \
    pdo_mysql \
    zip \
    mbstring \
    exif \
    pcntl \
    bcmath

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --optimize-autoloader \
    && composer clear-cache

ENTRYPOINT ["composer"]
