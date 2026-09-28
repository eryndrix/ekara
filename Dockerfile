# =====================================================================
# 1. PHP 8.5-FPM APPLICATION CONTAINER
# =====================================================================
FROM php:8.5-fpm AS app

# =====================================================================
# 2. ENVIRONMENT VARIABLES
# =====================================================================
ENV APP_TZ=Asia/Yekaterinburg \
    COMPOSER_HOME=/tmp/composer \
    COMPOSER_CACHE_DIR=/tmp/composer/cache

# =====================================================================
# 3. SYSTEM DEPENDENCIES
# =====================================================================
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        openssl \
        unzip \
        curl \
        netcat-openbsd \
        libpq-dev \
        libicu-dev \
        libzip-dev \
        libonig-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        pkg-config \
        autoconf \
        g++ \
        make \
        git \
        redis-tools \
        tzdata \
    && update-ca-certificates \
    && ln -snf /usr/share/zoneinfo/$APP_TZ /etc/localtime \
    && echo "$APP_TZ" > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata \
    && rm -rf /var/lib/apt/lists/*

# =====================================================================
# 4. NODE.JS 24
# =====================================================================
RUN curl -fsSL https://deb.nodesource.com/setup_24.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && node -v \
    && npm -v \
    && rm -rf /var/lib/apt/lists/*

# =====================================================================
# 4. SECURITY UPDATES
# =====================================================================
RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get clean \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/*

# =====================================================================
# 5. PHP EXTENSIONS (CORE)
# =====================================================================
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo \
        pdo_pgsql \
        mbstring \
        intl \
        zip \
        exif \
        sockets \
        pcntl \
    && git clone --depth 1 --branch 6.3.0 https://github.com/phpredis/phpredis.git /tmp/phpredis \
    && cd /tmp/phpredis \
    && phpize \
    && ./configure \
    && make -j$(nproc) \
    && make install \
    && docker-php-ext-enable redis \
    && cd / \
    && rm -rf /tmp/phpredis \
    && docker-php-source delete

# =====================================================================
# 6. PHP TIMEZONE CONFIGURATION
# =====================================================================
RUN echo "date.timezone = Asia/Yekaterinburg" > /usr/local/etc/php/conf.d/timezone.ini

# =====================================================================
# 7. NON-ROOT USER SETUP
# =====================================================================
ARG USER_ID=1000
ARG GROUP_ID=1000

RUN groupadd -g ${GROUP_ID} appgroup 2>/dev/null || true \
    && useradd -u ${USER_ID} -g ${GROUP_ID} -m -s /usr/sbin/nologin appuser 2>/dev/null || true

# =====================================================================
# 8. DIRECTORIES AND OWNERSHIP
# =====================================================================
RUN mkdir -p /tmp/composer/cache \
    && chown -R appuser:appgroup /tmp/composer

RUN mkdir -p /home/appuser/.composer/cache \
    && chown -R appuser:appgroup /home/appuser

# =====================================================================
# 9. WORKING DIRECTORY
# =====================================================================
WORKDIR /var/www/html

# =====================================================================
# 10. APPLICATION SOURCE CODE
# =====================================================================
COPY --chown=appuser:appgroup ./src /var/www/html

# =====================================================================
# 11. COMPOSER STAGE
# =====================================================================
FROM composer:2.10.1 AS composer-bin

# =====================================================================
# 12. FINAL APP STAGE
# =====================================================================
FROM app

COPY --from=composer-bin /usr/bin/composer /usr/local/bin/composer
RUN chown appuser:appgroup /usr/local/bin/composer \
    && /usr/local/bin/composer --version

# =====================================================================
# 13. STORAGE DIRECTORY
# =====================================================================
RUN mkdir -p storage/logs \
    && chown -R appuser:appgroup storage \
    && chmod -R 775 storage

# =====================================================================
# 14. PHP CONFIGURATION FILES
# =====================================================================
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# =====================================================================
# 15. QUEUE HELPER SCRIPT
# =====================================================================
COPY ./docker/rabbitmq/wait-for-rabbitmq.sh /usr/local/bin/wait-for-rabbitmq.sh
RUN chmod +x /usr/local/bin/wait-for-rabbitmq.sh \
    && chown appuser:appgroup /usr/local/bin/wait-for-rabbitmq.sh

# =====================================================================
# 16. EXPOSE PORT
# =====================================================================
EXPOSE 9000

# =====================================================================
# 17. SWITCH TO NON-ROOT USER
# =====================================================================
USER appuser

# =====================================================================
# 18. START PHP-FPM
# =====================================================================
CMD ["php-fpm"]
