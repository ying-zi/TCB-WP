FROM wordpress:5.7.1

COPY custom.ini $PHP_INI_DIR/conf.d/custom.ini

CMD ["apachectl", "restart"]
