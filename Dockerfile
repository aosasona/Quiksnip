FROM php:8.1-apache

USER root

COPY web.conf /etc/apache2/sites-available/web.conf

COPY start /usr/local/bin

RUN a2enmod rewrite

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y libpq-dev \
    && apt-get install -y git

ENTRYPOINT ["start"]
