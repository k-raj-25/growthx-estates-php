# syntax=docker/dockerfile:1

FROM node:22-bookworm-slim AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

FROM php:8.4-apache-bookworm

RUN a2enmod rewrite headers \
  && apt-get update \
  && apt-get install -y --no-install-recommends \
       libicu-dev \
       libzip-dev \
       libpng-dev \
       libjpeg62-turbo-dev \
       libfreetype6-dev \
       libonig-dev \
       libxml2-dev \
       libsqlite3-dev \
       libpq-dev \
       git \
       unzip \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j"$(nproc)" intl pdo_mysql pdo_pgsql pdo_sqlite zip opcache bcmath gd \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    APP_ENV=production \
    LOG_CHANNEL=stderr

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts \
  && chown -R www-data:www-data storage bootstrap/cache

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
