FROM php:7.3-fpm
LABEL maintainer="hello@guillaumebriday.fr"

# Installing dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mysql-client \
    libpng-dev \
    libzip-dev \
    locales \
    zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installing extensions
RUN docker-php-ext-install pdo_mysql gd mbstring zip opcache

# Installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Changing Workdir
WORKDIR /var/www
