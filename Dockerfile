FROM php:8.2-apache

# 1. Instalar dependencias del sistema (libpq-dev es crucial para PostgreSQL, libzip-dev para archivos comprimidos)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    gnupg

# 2. Instalar extensiones de PHP necesarias para Laravel y PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip

# 3. Instalar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Instalar Node.js v20 (Requerido para que Vite y Tailwind compilen sin el error de CustomEvent)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 5. Configurar Apache para apuntar correctamente a la carpeta /public de Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# 6. Copiar los archivos del proyecto al espacio de trabajo del contenedor
COPY . /var/www/html

# 7. Asignar permisos recursivos totales y cambiar el propietario al usuario de Apache (www-data)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# 8. Instalar dependencias de PHP para producción y compilar assets con Vite
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs
RUN npm install
RUN npm run build

# 9. Script de arranque con limpieza total de base de datos (migrate:fresh) y optimización de caché
RUN printf "#!/bin/sh\n\
php artisan migrate:fresh --seed --force\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
apachectl -D FOREGROUND\n" > /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh

# Ejecutar el script automatizado al iniciar el contenedor
CMD ["/usr/local/bin/start.sh"]