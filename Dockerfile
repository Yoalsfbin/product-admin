FROM richarvey/nginx-php-fpm:3.1.6

USER root
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*
USER root

WORKDIR /var/www/html
COPY . .

# Image config
ENV SKIP_COMPOSER 0               # ← Composer自動実行を有効化（または行自体削除）
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr


RUN php artisan route:cache || true \
 && php artisan view:cache || true \
 && php artisan config:cache || true


ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]
