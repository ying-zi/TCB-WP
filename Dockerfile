FROM wordpress:latest
COPY ./wp /var/www/html/
COPY custom.ini $PHP_INI_DIR/conf.d/custom.ini
