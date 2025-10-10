#!/bin/bash

# Deployment script for Kelas Digital Beautyversity

set -e # Exit on any error

echo "Starting deployment..."

# Pull latest changes
git pull origin main

# Install/update PHP dependencies
composer install --optimize-autoloader --no-dev

# Install/update JavaScript dependencies
npm install

# Build frontend assets for production
npm run build

# Run database migrations (if any)
php artisan migrate --force

# Cache configuration, routes, and views for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear any old caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Set correct permissions
chmod -R 75 storage
chmod -R 755 bootstrap/cache

echo "Deployment completed successfully!"