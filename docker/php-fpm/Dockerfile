FROM php:7.4-fpm

RUN apt-get update && apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl libpq-dev git libicu-dev libpng-dev libjpeg62-turbo-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_pgsql pgsql gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -

WORKDIR /var/www/symfony
