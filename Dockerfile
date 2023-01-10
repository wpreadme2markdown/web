FROM php:8.1-apache

RUN apt-get update && apt-get install -y zip
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

COPY . /var/www/html
RUN /usr/local/bin/composer install --prefer-dist
