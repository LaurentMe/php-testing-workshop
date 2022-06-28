FROM php:8.1-alpine3.16

RUN apk add icu-dev && \
  docker-php-ext-install -j$(nproc) pdo_mysql intl bcmath

WORKDIR /var/www/app

CMD [ "php", "-S", "0.0.0.0:8080", "-t", "public/" ]
