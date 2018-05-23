FROM php:7-apache

RUN docker-php-ext-install mysqli

RUN apt-get install -y libicu-dev

RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++

RUN docker-php-ext-configure intl

RUN docker-php-ext-install intl

RUN docker-php-ext-install mbstring

COPY src/ /var/www/html/