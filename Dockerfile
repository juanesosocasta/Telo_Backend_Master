# Usar imagen oficial de PHP 7.4 con Apache
FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    # Extensiones adicionales para Laravel
    libicu-dev \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl

# Aumenta el límite de memoria para Composer
ENV COMPOSER_MEMORY_LIMIT=-1

# Copia el código de la app al contenedor
COPY . /var/www/html

# Instala Composer (si no está ya en la imagen base)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala dependencias de Composer
RUN composer install --no-dev --optimize-autoloader



# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copia la configuración de Apache
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Configurar ServerName para Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar el proyecto al contenedor
COPY . /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Establece permisos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache
