# Partir de l'image officielle de PHP comme base
# https://hub.docker.com/_/php
FROM php:8.2-apache

# Installer l'extension pdo_pgsql
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql

# Activer le module de réécriture d'URL
RUN a2enmod rewrite

# Ajouter configuration PHP custom
COPY conf/php/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

# Désactiver le vhost par défaut
RUN a2dissite 000-default.conf

# Définir et activer notre vhost custom
COPY conf/php/site.conf /etc/apache2/sites-available/site.conf
RUN a2ensite site
