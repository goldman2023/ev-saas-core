FROM php:7.4-fpm-alpine
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions pdo_mysql gd  exif pcntl bcmath zip gmp intl @composer
RUN apk add --no-cache --upgrade bash nodejs npm git
WORKDIR /var/www/html/
COPY run.sh ./
RUN chmod +x run.sh
ENTRYPOINT ["/bin/sh","run.sh"]
