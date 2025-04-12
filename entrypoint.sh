#!/bin/sh

# Fix permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Start PHP-FPM or whatever your app uses
php-fpm
