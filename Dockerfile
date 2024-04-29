# Define the base image as Debian Buster Slim (lightweight)
FROM debian:buster-slim

# Update package lists
RUN apt-get update

# Install essential packages
RUN apt-get install -y \
    apache2 \
    php8.2 \
    php8.2-cli \
    php8.2-curl \
    php8.2-gd \
    php8.2-json \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-zip \
    composer

# Expose port 80 for web traffic
EXPOSE 80

# Set working directory
WORKDIR /var/www/html

# Install project dependencies using Composer
RUN composer install --ignore-platform-reqs

# Copy project files
COPY . .

# Enable Apache modules
RUN a2enmod rewrite headers

# Configure Apache virtual host (replace 'your_domain' with your actual domain)
RUN echo "
<VirtualHost *:80>
    ServerAdmin webmaster@your_domain
    DocumentRoot /var/www/html
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
</VirtualHost>
" > /etc/apache2/sites-available/000-default.conf

# Restart Apache
RUN service apache2 restart

# Run Apache in foreground (optional)
CMD ["apache2", "-D"]
