# -----------------------------------------------
# Imagen base: PHP 7.4 + Apache (Debian Bullseye)
# -----------------------------------------------
    FROM php:7.4-apache-bullseye

    # -----------------------------------------------
    # Variables de entorno esenciales
    # -----------------------------------------------
    ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
    ENV COMPOSER_MEMORY_LIMIT=-1
    ENV APP_ENV=production
    
    # -----------------------------------------------
    # 1. Instalación de dependencias del sistema
    # -----------------------------------------------
    RUN apt-get update && apt-get install -y \
        # Dependencias generales
        git \
        unzip \
        zip \
        # Dependencias para PHP
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        libpq-dev \
        libicu-dev \
        # Extensiones PHP
        && docker-php-ext-install \
            pdo \
            pdo_pgsql \
            mbstring \
            exif \
            pcntl \
            bcmath \
            gd \
            zip \
            intl \
        # Limpieza
        && apt-get clean \
        && rm -rf /var/lib/apt/lists/*
    
    # -----------------------------------------------
    # 2. Configuración de Apache para Render
    # -----------------------------------------------
    RUN echo "Listen 10000" > /etc/apache2/ports.conf && \
        a2enmod rewrite && \
        a2dissite 000-default && \
        sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf && \
        sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
    
    # -----------------------------------------------
    # 3. Configuración personalizada de Apache
    # -----------------------------------------------
    COPY docker/apache/000-default.conf /etc/apache2/sites-available/
    
    # -----------------------------------------------
    # 4. Instalación de Composer
    # -----------------------------------------------
    COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
    
    # -----------------------------------------------
    # 5. Copia de archivos del proyecto
    # -----------------------------------------------
    WORKDIR /var/www/html
    
    # Primero copiamos solo los archivos de Composer
    COPY composer.json composer.lock ./
    
    # Instalamos dependencias de PHP
    RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts
    
    # Copiamos el resto del proyecto
    COPY . .
    
    # -----------------------------------------------
    # 6. Configuración final de la aplicación
    # -----------------------------------------------
    # Permisos para Laravel
    RUN chown -R www-data:www-data storage bootstrap/cache && \
        chmod -R 775 storage bootstrap/cache
    
    # Ejecutar scripts post-instalación
    RUN composer dump-autoload --optimize
    
    # -----------------------------------------------
    # 7. Exposición del puerto para Render
    # -----------------------------------------------
    EXPOSE 10000
    
    # -----------------------------------------------
    # 8. Comando de inicio (para Render)
    # -----------------------------------------------
    CMD ["apache2-foreground"]
    