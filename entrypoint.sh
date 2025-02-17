#!/bin/bash

# Install composer dependencies
composer install --optimize-autoloader --no-dev --no-interaction

# Install npm dependencies
npm install

# Build assets
npm run build

# Run migrations and clear caches
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM
exec "$@"
