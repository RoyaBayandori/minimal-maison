# Minimal Maison — WordPress PHP 8.3 FPM with extensions for WooCommerce & Redis
FROM wordpress:php8.3-fpm

LABEL org.opencontainers.image.title="Minimal Maison WordPress"
LABEL org.opencontainers.image.description="PHP 8.3 FPM WordPress image with Redis and WooCommerce-ready extensions"

# System dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    libicu-dev \
    libmagickwand-dev \
    unzip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions (WooCommerce: gd, zip, intl, mbstring, mysqli, curl, exif, bcmath)
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
        gd \
        zip \
        intl \
        exif \
        bcmath \
        opcache

# Redis extension for object caching
RUN pecl install redis \
    && docker-php-ext-enable redis

# Optional: ImageMagick for advanced image processing
RUN pecl install imagick \
    && docker-php-ext-enable imagick \
    || true

# Custom PHP configuration
COPY php.ini /usr/local/etc/php/conf.d/zz-minimal-maison.ini
COPY docker/wordpress/wp-config-extra.php /usr/local/etc/wordpress/wp-config-extra.php

# Log directory
RUN mkdir -p /var/log/php && chown www-data:www-data /var/log/php

WORKDIR /var/www/html
