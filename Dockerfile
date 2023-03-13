FROM php:8.0-apache
RUN apt-get update && apt-get install -y \
libonig-dev p7zip p7zip-full zip unzip zlib1g-dev libzip-dev\
&& docker-php-ext-install pdo_mysql zip

# PHPのドキュメントルート変更(XAMPPでいうところのhtdocs)
# ENV APACHE_DOCUMENT_ROOT /app/
# COPY . /app/
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf 
# RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer/composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html



