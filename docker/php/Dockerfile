FROM php:8.2-fpm-bullseye

# Install xdebug and enable it using the docker-php-ext-enable command built into the PHP docker image
RUN pecl install xdebug-3.2.0 \
    && docker-php-ext-enable xdebug

# Install PHP extensions using the docker-php-ext-install script built into the image
# MySQLi and PDO are PHP's basic database drivers
RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./error-logging.ini /usr/local/etc/php/conf.d/error-logging.ini