FROM php:7.4-apache

RUN apt-get update && apt-get install -y zlib1g-dev libpng-dev libjpeg-dev libgif-dev
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd

RUN docker-php-ext-install mysqli

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY . /var/www/html

WORKDIR /var/www/html

RUN a2enmod rewrite && service apache2 restart

EXPOSE 80 9000