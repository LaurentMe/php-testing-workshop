FROM php:8.1-alpine3.16

RUN docker-php-ext-install -j$(nproc) pdo_mysql

WORKDIR /var/www/app

CMD [ "php", "-S", "0.0.0.0:8080", "-t", "public/" ]
