# Use official PHP Apache image
FROM php:8.2-apache

# System dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files to container
COPY . /var/www/html

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Fix storage & bootstrap permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Set Apache DocumentRoot to public/
WORKDIR /var/www/html/public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Cache Laravel config, routes, views
WORKDIR /var/www/html
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache || true

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
