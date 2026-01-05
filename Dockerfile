# Base image PHP 8.2 + Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Aktifkan mod_rewrite Apache
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
    && docker-php-ext-install gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy seluruh project ke container
COPY . /var/www/html

# Set permission
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Set Apache DocumentRoot ke folder public
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Jalankan Apache di foreground
CMD ["apache2-foreground"]
