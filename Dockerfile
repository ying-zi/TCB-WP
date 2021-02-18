FROM php:7.3-apache
COPY ./napi /var/www/html/
COPY custom.ini $PHP_INI_DIR/conf.d/custom.ini
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
