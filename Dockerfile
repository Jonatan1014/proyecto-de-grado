FROM php:8.1-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite para el enrutamiento
RUN a2enmod rewrite

# Copiar archivos del proyecto completo
COPY . /var/www/html/

# Cambiar al directorio src/public para que sea la raíz web
WORKDIR /var/www/html/src/public

# Copiar el contenido de src/public a la raíz web
RUN cp -r /var/www/html/src/public/* /var/www/html/ && \
    rm -rf /var/www/html/src

# Exponer el puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]