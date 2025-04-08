# Official PHP 8.2 image with Apache
FROM php:8.2-apache

# Install exstension PHP, required for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip unzip git curl \
    && docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set work folder
WORKDIR /var/www/html

# Copy code into container
COPY . .
COPY apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Set permissons storage і bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Open 80 post and run Apache
EXPOSE 80
CMD ["apache2-foreground"]
