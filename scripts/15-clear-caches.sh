#!/usr/bin/env sh
set -e
cd /var/www/html

php artisan route:clear   || true
php artisan config:clear  || true
php artisan cache:clear   || true
php artisan view:clear    || true
