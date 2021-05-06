FROM ccr.ccs.tencentyun.com/tcb_public/wordpress

COPY custom.ini $PHP_INI_DIR/conf.d/custom.ini

CMD ["apachectl", "restart"]
