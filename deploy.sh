#!/bin/bash
set -e

echo "Starting deployment..."

# Navigate to the project directory
# Change this to your project's absolute path on the server
# cd /path/to/your/project

# Pull the latest changes from the main branch
git pull origin main

# Install PHP dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations
php artisan migrate --force

# Clear and rebuild cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployment finished successfully!"
