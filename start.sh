#!/bin/sh

# Exit on error
set -e

# Replace the ${PORT} variable in nginx config with the one provided by Render
envsubst '${PORT}' < /etc/nginx/sites-available/default > /etc/nginx/sites-available/default.tmp
mv /etc/nginx/sites-available/default.tmp /etc/nginx/sites-available/default

# Cache Laravel configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations (will execute if database variables are set)
php artisan migrate --force

# Start PHP-FPM in the background
php-fpm -D

# Start Nginx in the foreground
nginx -g "daemon off;"