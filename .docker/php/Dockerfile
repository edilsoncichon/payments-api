FROM php:8.4-fpm

ARG USER_ID
ARG GROUP_ID

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    default-mysql-client \
    libicu-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data

RUN git config --global --add safe.directory /var/www

RUN mkdir /tmp/composer

RUN chown -R www-data:www-data /var/www /tmp/composer

WORKDIR /var/www

USER www-data
