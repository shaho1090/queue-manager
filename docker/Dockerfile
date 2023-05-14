FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

ENV COMPOSER_ALLOW_SUPERUSER = 1

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

RUN chmod -R 777 storage
RUN chmod -R 777 bootstrap/cache

#COPY ./app/composer.* ./
