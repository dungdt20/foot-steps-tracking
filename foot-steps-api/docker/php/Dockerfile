FROM php:7.4-fpm as base

RUN apt-get update -y && apt-get clean

RUN apt-get update && apt-get install -y \
    supervisor \
    zlib1g-dev \
    libicu-dev \
    g++ \
    zip \
    unzip \
    ssh \
    libssl-dev \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install addition php ext
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl mysqli opcache pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && pecl install redis-5.3.7 \
    && docker-php-ext-enable redis

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./docker/php/conf.d/redis.ini /usr/local/etc/php/conf.d/redis.ini

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="10000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="192" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

WORKDIR /app

FROM base as test

WORKDIR /app

COPY --chown=www-data:www-data . /app

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install \
        --prefer-dist \
        --no-ansi \
        --no-interaction \
        --no-progress \
        --no-scripts \
        --optimize-autoloader

RUN composer dump-autoload

ARG PUID=10006
ENV PUID ${PUID}
ARG PGID=10006
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

RUN chown -R www-data:www-data /app/storage \
    && chmod -R 775 /app/storage \
    && chmod -R 775 /app/bootstrap

COPY ./docker/php/start.sh /usr/local/bin/start
RUN chmod u+x /usr/local/bin/start

FROM base as build

WORKDIR /app

COPY --chown=www-data:www-data composer.json composer.lock /app/

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install \
        --prefer-dist \
        --no-ansi \
        --no-interaction \
        --no-progress \
        --no-scripts \
        --no-dev \
        --optimize-autoloader

RUN composer dump-autoload

FROM base as run

ARG PUID=10006
ENV PUID ${PUID}
ARG PGID=10006
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

COPY --chown=www-data:www-data ./app /app/app
COPY --chown=www-data:www-data ./bootstrap /app/bootstrap
COPY --chown=www-data:www-data ./config /app/config
COPY --chown=www-data:www-data ./public /app/public
COPY --chown=www-data:www-data ./routes /app/routes
COPY --chown=www-data:www-data ./src /app/src
COPY --chown=www-data:www-data ./storage /app/storage
COPY --chown=www-data:www-data ./artisan /app/
COPY --chown=www-data:www-data ./version /app/
COPY --chown=www-data:www-data ./composer.json /app/
COPY --chown=www-data:www-data ./composer.lock /app/
COPY --chown=www-data:www-data ./spec /app/spec

COPY --chown=www-data:www-data --from=build /app/vendor /app/vendor

RUN chown -R www-data:www-data /app/storage \
    && chmod -R 775 /app/storage \
    && chmod -R 775 /app/bootstrap

COPY ./docker/php/start.sh /usr/local/bin/start
RUN chmod u+x /usr/local/bin/start
