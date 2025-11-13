FROM php:7.4-apache

ARG NODE_VERSION=18

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        gnupg2 \
        ca-certificates \
        curl \
        git \
        unzip \
        libzip-dev \
        libonig-dev \
        zip \
    && curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && docker-php-ext-install mysqli pdo pdo_mysql bcmath \
    && npm install -g grunt-cli bower \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 0644 {} \; \
    && find /var/www/html -type d -exec chmod 0755 {} \;

EXPOSE 80

CMD ["apache2-foreground"]



