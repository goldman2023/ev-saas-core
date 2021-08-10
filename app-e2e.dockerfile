FROM php:7.4-fpm-alpine as fpm
WORKDIR /var/www/html/
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions pdo_mysql gd  exif pcntl bcmath zip gmp intl @composer
RUN apk add --no-cache --upgrade bash git
FROM composer:latest as vendor
WORKDIR /var/www/html/
COPY . .
RUN composer install --no-interaction --prefer-dist --no-scripts --no-autoloader --ignore-platform-req=ext-gd
FROM node:lts-alpine as node
WORKDIR /var/www/html/
COPY . .
RUN npm ci && npm run prod
FROM fpm
WORKDIR /var/www/html/
COPY . .
COPY --from=node /var/www/html/public/ ./public/
COPY --from=vendor /var/www/html/vendor/ ./vendor/
COPY run-e2e.sh ./
RUN chmod +x run-e2e.sh
ENTRYPOINT ["/bin/sh","run-e2e.sh"]
