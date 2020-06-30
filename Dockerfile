FROM signifly/php-7.4:1.3

USER www-data:www-data

COPY --chown=www-data:www-data composer.json composer.lock $WORK_DIR/
RUN /utils/composer.sh
COPY --chown=www-data:www-data . $WORK_DIR/
RUN /utils/autoloader.sh

USER root

