# Use PHP 8.2 FPM Ubuntu as base image
FROM php:8.2-fpm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql opcache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    bash \
    zip  \
    unzip  \
    openssh-client \
    curl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www