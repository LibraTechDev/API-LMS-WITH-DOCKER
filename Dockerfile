FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    libzip-dev \
    lsb-release \
    ca-certificates \
    gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure zip \
    && docker-php-ext-install gd pdo pdo_mysql intl zip

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN npm install -g npm