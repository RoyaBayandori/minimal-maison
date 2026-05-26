# Minimal Maison — lightweight PHP 8.3 FPM for local development (Apple Silicon friendly)
#
# Minimal compile footprint: -j1 avoids OOM during docker build.
# Base image includes mysqli, pdo_mysql, mbstring, curl, json, xml.
#
FROM wordpress:php8.3-fpm

LABEL org.opencontainers.image.title="Minimal Maison WordPress"
LABEL org.opencontainers.image.description="Lightweight PHP 8.3 FPM for local WordPress + WooCommerce dev"

RUN apt-get update && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libwebp-dev \
        libzip-dev \
        libicu-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j1 \
        gd \
        zip \
        intl \
        bcmath \
        opcache \
    && rm -rf /var/lib/apt/lists/*

COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-minimal-maison.ini
COPY docker/wordpress/wp-config-extra.php /usr/local/etc/wordpress/wp-config-extra.php

RUN mkdir -p /var/log/php && chown www-data:www-data /var/log/php

WORKDIR /var/www/html
