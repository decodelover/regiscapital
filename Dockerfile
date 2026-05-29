FROM php:8.1-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    curl \
    zip \
    unzip \
    git \
    nodejs \
    npm \
    gettext \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip bcmath pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default
RUN mkdir -p /run/nginx

# Install PHP dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm ci && npm run prod

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Make start script executable
RUN chmod +x start.sh

# Render provides the PORT environment variable natively
ENV PORT=10000

# Start the application
CMD ["/var/www/html/start.sh"]