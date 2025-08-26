FROM richarvey/nginx-php-fpm:3.1.6

USER root

RUN apk add --no-cache --virtual .build-deps \
      $PHPIZE_DEPS postgresql-dev \
  && docker-php-ext-install pdo_pgsql \
  && apk del .build-deps

WORKDIR /var/www/html


COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --no-scripts


COPY . .


RUN rm -f bootstrap/cache/routes-*.php bootstrap/cache/config.php \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R ug+rwx storage bootstrap/cache


RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader


COPY docker/nginx-laravel.conf /etc/nginx/conf.d/default.conf


ENV RUN_SCRIPTS=1 \
    SKIP_COMPOSER=1 \
    WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    REAL_IP_HEADER=1 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr


CMD ["/bin/sh","-lc","rm -f bootstrap/cache/routes-*.php bootstrap/cache/config.php && /start.sh"]
