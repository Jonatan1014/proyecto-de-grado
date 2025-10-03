FROM php:8.1-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite para el enrutamiento
RUN a2enmod rewrite

# Copiar archivos del proyecto completo
COPY . /var/www/html/

# Establecer DocumentRoot a src/public
RUN echo "DocumentRoot /var/www/html/src/public" > /etc/apache2/sites-available/000-default.conf

# Exponer el puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]