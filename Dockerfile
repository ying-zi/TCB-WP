FROM php:7.3-apache

COPY --chown=www-data:www-data  ./napi /var/www/html/

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" && apt update && apt install -y libpng-dev && docker-php-ext-install gd

CMD ["apachectl", "-DFOREGROUND"]
