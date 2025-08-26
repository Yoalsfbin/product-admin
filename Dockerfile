FROM richarvey/nginx-php-fpm:3.1.6

USER root

RUN apk add --no-cache --virtual .build-deps \
      $PHPIZE_DEPS postgresql-dev \
  && docker-php-ext-install pdo_pgsql \
  && apk del .build-deps

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

COPY . .

ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV REAL_IP_HEADER=1
ENV COMPOSER_ALLOW_SUPERUSER=1

ENV RUN_SCRIPTS=0


ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

CMD ["/start.sh"]
