# Base image PHP 8.2 + Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Enable Apache mod_rewrite (wajib untuk CodeIgniter 4)
RUN a2enmod rewrite

# Install PHP extensions yang dibutuhkan CI4 + MySQL
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libzip-dev \
        zip \
        unzip \
        git \
    && docker-php-ext-install pdo pdo_mysql mysqli mbstring zip exif pcntl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Copy project ke container
COPY . /var/www/html

# Set permission
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
