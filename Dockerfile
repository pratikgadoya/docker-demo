FROM php:7.0-apache

RUN docker-php-ext-install -j$(nproc) mysqli


# docker run --name wordpressdb -e MYSQL_ROOT_PASSWORD=root -d mysql:5.7
# docker run --name wordpress php:5.6-apache
# docker run --name wordpress -v "$PWD/":/var/www/html php:5.6-apache

FROM php:5.6-apache
RUN docker-php-ext-install mysqli
CMD ["apache2-foreground"]