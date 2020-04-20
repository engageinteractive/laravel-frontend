FROM php:7.4-fpm-alpine

RUN apk update \
    && apk add \
        build-base \
        libzip-dev \
    && docker-php-ext-install pdo_mysql zip bcmath \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename composer
