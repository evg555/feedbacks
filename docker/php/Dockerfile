FROM php:7.4-apache

RUN docker-php-ext-install mysqli

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY . /var/www/html

WORKDIR /var/www/html

EXPOSE 80 9000