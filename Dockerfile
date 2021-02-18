FROM php:7.3-apache
COPY ./napi /var/www/html/
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
