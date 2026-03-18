#!/bin/sh
set -e

echo "Starting F1 Mini System..."

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Create storage symlink (if not exists)
php artisan storage:link 2>/dev/null || true

echo "Application ready!"

# Execute the main container command (php-fpm)
exec "$@"
