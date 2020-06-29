FROM php:7.4-fpm-alpine

WORKDIR /var/www/

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev zlib-dev libpng-dev

RUN docker-php-ext-install pdo pdo_pgsql gd
