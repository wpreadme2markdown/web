FROM php:8.0-apache

RUN ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

COPY . /var/www/html
