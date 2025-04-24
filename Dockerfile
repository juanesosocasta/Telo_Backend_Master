# Usar imagen base específica para evitar conflictos
FROM php:7.4-apache-bullseye


# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configura Apache
RUN a2enmod rewrite && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copia archivos de Composer primero
WORKDIR /var/www/html
COPY composer.json composer.lock ./

# Instala Composer y dependencias
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --optimize-autoloader


# Copia la configuración de Apache ANTES de ejecutar comandos
COPY docker/apache/000-default.conf /tmp/000-default.conf

# Configura Apache
RUN a2enmod rewrite && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    mv /tmp/000-default.conf /etc/apache2/sites-available/000-default.conf


# Instalar dependencias y extensiones para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip intl


RUN docker-php-ext-install pdo pdo_pgsql



# Configurar Apache para Render
RUN echo "Listen 10000" > /etc/apache2/ports.conf && \
    a2enmod rewrite

# Permisos para Laravel
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Configurar Apache para Render
RUN echo "Listen 10000" > /etc/apache2/ports.conf

EXPOSE 10000