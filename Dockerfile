# =========================
# 1) composer stage
# =========================
FROM composer:2 AS composer-build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

COPY . .
RUN composer dump-autoload -o

# =========================
# 2) node/vite stage
# =========================
FROM node:20-alpine AS node-build
WORKDIR /app
COPY package.json package-lock.json* pnpm-lock.yaml* yarn.lock* ./

RUN \
  if [ -f package-lock.json ]; then npm ci --include=dev; \
  elif [ -f pnpm-lock.yaml ]; then npm i -g pnpm && pnpm i --frozen-lockfile; \
  elif [ -f yarn.lock ]; then corepack enable && yarn install --frozen-lockfile; \
  else echo "no lockfile, doing npm install" && npm install --production=false; fi
COPY . .
RUN npm run build

# =========================
# 3) final stage (richarvey)
# =========================
FROM richarvey/nginx-php-fpm:3.1.6


USER root
RUN set -eux; \
    apk add --no-cache $PHPIZE_DEPS; \
    docker-php-ext-install pdo_mysql; \
    apk add --no-cache postgresql-dev; \
    docker-php-ext-install pdo_pgsql; \
    apk del --no-network $PHPIZE_DEPS

WORKDIR /var/www/html

COPY --chown=nginx:nginx . .
COPY --from=composer-build --chown=nginx:nginx /app/vendor ./vendor
COPY --from=node-build     --chown=nginx:nginx /app/public/build ./public/build


RUN set -eux; \
  mkdir -p storage/logs storage/framework/{cache,data,sessions,testing,views} && \
  chown -R nginx:nginx storage bootstrap/cache public/build && \
  find storage -type d -exec chmod 775 {} \; && \
  find storage -type f -exec chmod 664 {} \; && \
  chmod -R ug+rwx bootstrap/cache && \

  rm -f bootstrap/cache/routes-*.php bootstrap/cache/config.php bootstrap/cache/packages.php bootstrap/cache/services.php


COPY --chown=root:root docker/nginx-laravel.conf /etc/nginx/conf.d/default.conf


ENV RUN_SCRIPTS=1 \
    SKIP_COMPOSER=1 \
    WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    REAL_IP_HEADER=1 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr


CMD ["/bin/sh","-lc","rm -f bootstrap/cache/routes-*.php bootstrap/cache/config.php bootstrap/cache/packages.php bootstrap/cache/services.php && /start.sh"]
