FROM php:8.2-apache

# Activer mysqli et pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activer mod_rewrite pour routes “propres”
RUN a2enmod rewrite

WORKDIR /var/www/html
