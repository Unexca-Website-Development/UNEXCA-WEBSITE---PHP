FROM php:7.4-apache

# Instalar dependencias del sistema y librerías para Postgres
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite de Apache (Necesario para tu enrutamiento MVC)
RUN a2enmod rewrite

# Configurar el DocumentRoot para que apunte a /var/www/html (raíz del proyecto)
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar el código fuente
COPY . /var/www/html/

# Dar permisos al usuario www-data (Apache)
RUN chown -R www-data:www-data /var/www/html
