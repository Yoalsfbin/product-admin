#!/usr/bin/env sh
set -e
cd /var/www/html
echo "=== route:list (production) ===" 1>&2
php artisan route:list 1>&2 || true
echo "=== route:list --path=login ===" 1>&2
php artisan route:list --path=login 1>&2 || true
