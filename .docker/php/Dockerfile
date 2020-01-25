FROM php:fpm

RUN apt-get update

RUN apt-get install -y \
        git \
        libzip-dev \
        unzip \
        && docker-php-ext-install zip

# Install xdebug
RUN pecl install xdebug-2.9.1 \
    && docker-php-ext-enable xdebug

RUN curl https://getcomposer.org/composer-stable.phar --output /usr/bin/composer
RUN chmod +x /usr/bin/composer

WORKDIR /app

COPY entrypoint.sh /usr/bin/entrypoint.sh
ENTRYPOINT [ "sh", "/usr/bin/entrypoint.sh" ]