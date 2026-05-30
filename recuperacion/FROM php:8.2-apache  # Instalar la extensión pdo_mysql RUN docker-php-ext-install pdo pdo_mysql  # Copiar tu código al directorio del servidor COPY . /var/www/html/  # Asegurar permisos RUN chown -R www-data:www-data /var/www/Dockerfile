FROM php:8.2-apache

# Instalar la extensión pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Copiar tu código al directorio del servidor
COPY . /var/www/html/

# Asegurar permisos
RUN chown -R www-data:www-data /var/www/html
