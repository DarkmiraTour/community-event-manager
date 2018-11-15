FROM php:7.2-fpm

RUN apt-get update

RUN apt-get install -y libpq-dev git libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_pgsql pgsql

WORKDIR /var/www/symfony
