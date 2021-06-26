FROM wordpress:php7.4

RUN apt-get update \
    && apt-get install ssl-cert \
    && a2enmod ssl \
    && a2ensite default-ssl

RUN pecl install "xdebug" \
    && docker-php-ext-enable xdebug

COPY . /var/www/html/
