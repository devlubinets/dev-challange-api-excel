FROM php:fpm

### Common additional
# Sys packages
RUN apt-get -y update
RUN apt-get -y install git libzip-dev zip libicu-dev libpng-dev libjpeg-dev

### PHP's modules

RUN docker-php-ext-install intl zip pdo pdo_mysql gd
# PDO
RUN docker-php-ext-install pdo pdo_mysql
# Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN mkdir -p /var/www/log
RUN touch /var/www/log/xdebug.log

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# todo separate user creation
# Add user for laravel application
RUN groupadd -g 1000 ad
RUN useradd -u 1000 -ms /bin/bash -g ad ad

# Work in the specific space
WORKDIR /app
USER ad

