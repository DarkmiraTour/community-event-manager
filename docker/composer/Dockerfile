FROM php:7.4-cli

RUN apt-get update && apt-get install --no-install-recommends --assume-yes --quiet ca-certificates unzip libzip-dev curl libpq-dev git libicu-dev libpng-dev libjpeg62-turbo-dev \
 && docker-php-ext-configure intl \
 && docker-php-ext-install intl pdo pdo_pgsql pgsql gd zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/* \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/symfony

COPY docker-entrypoint.sh /docker-entrypoint.sh

ENTRYPOINT ["/bin/sh", "/docker-entrypoint.sh"]

CMD ["composer"]
