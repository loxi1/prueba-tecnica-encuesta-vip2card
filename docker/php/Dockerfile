FROM php:8.3-fpm-alpine

# Extensiones necesarias para Laravel + MariaDB
RUN apk add --no-cache \
    git curl zip unzip tzdata icu-dev libzip-dev oniguruma-dev \
    mariadb-client \
 && docker-php-ext-install pdo pdo_mysql intl zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Opcional: Xdebug para desarrollo
# RUN pecl install xdebug && docker-php-ext-enable xdebug

WORKDIR /var/www/html

