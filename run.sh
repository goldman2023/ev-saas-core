#!/bin/bash
./wait-for-it.sh db:3306 -t 120
php artisan key:generate --force
php artisan migrate --force
php artisan passport:install --force
php artisan db:seed
chown -R www-data:www-data storage/
php-fpm
