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

RUN groupadd --force qmuser
RUN useradd -ms /bin/bash qmuser --no-user-group -g qmuser

USER qmuser
COPY --chown=qmuser:qmuser composer.json composer.lock ./
COPY --chown=qmuser:qmuser . .

#COPY ./app/composer.* ./
