# syntax=docker/dockerfile:1
FROM php:8.4-fpm-alpine AS base

LABEL maintainer="Virtual Tour"

# System dependencies
RUN apk add --no-cache \
    bash \
    curl \
    freetype-dev \
    git \
    icu-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    nginx \
    nodejs \
    npm \
    oniguruma-dev \
    postgresql-dev \
    shadow \
    supervisor \
    unzip

# PHP extensions
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pdo \
        pdo_pgsql \
        pcntl \
        xml \
        zip

# Redis extension (phpredis)
RUN pecl install redis \
    && docker-php-ext-enable redis

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP production ini
COPY docker/php/php-production.ini /usr/local/etc/php/conf.d/99-production.ini

# Create non-root user
RUN addgroup -g 1001 -S laravel \
    && adduser -u 1001 -S laravel -G laravel

WORKDIR /var/www/html

# ─── Build stage: install deps & compile assets ──────────────────────────────
FROM base AS builder

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-autoloader \
    --no-scripts \
    --prefer-dist

COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY . .

RUN composer dump-autoload --optimize --no-dev \
    && npm run build

# ─── Production image ─────────────────────────────────────────────────────────
FROM base AS production

COPY --from=builder --chown=laravel:laravel /var/www/html /var/www/html

RUN rm -rf node_modules \
    && chown -R laravel:laravel /var/www/html/storage /var/www/html/bootstrap/cache

COPY --chmod=755 docker/entrypoint.sh /entrypoint.sh
USER laravel

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
