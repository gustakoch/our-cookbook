FROM php:7.3-apache
RUN a2enmod rewrite
RUN apt-get update && apt-get install -y \
    && docker-php-ext-install pdo_mysql