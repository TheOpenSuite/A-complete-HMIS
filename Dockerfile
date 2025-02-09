# Use official PHP-Apache image
FROM php:8.1-apache

# Enable mysqli extension (required for MySQL)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy PHP files to container
COPY src/ /var/www/html/

# Enable Apache rewrite module (if needed)
RUN a2enmod rewrite
