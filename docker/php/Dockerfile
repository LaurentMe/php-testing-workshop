FROM composer:2.3 AS composer

FROM php:8.1-alpine3.16

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk add icu-dev && \
  docker-php-ext-install -j$(nproc) pdo_mysql intl bcmath

WORKDIR /var/www/app

CMD [ "php", "-S", "0.0.0.0:80", "-t", "public/" ]
