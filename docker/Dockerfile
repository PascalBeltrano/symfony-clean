FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        locales \
        apt-utils \
        git \
        libicu-dev \
        g++ \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        libxslt-dev \
        libpq-dev \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_pgsql \
        zip \
        intl \
        opcache



RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /var/www/

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "symfony/public"]