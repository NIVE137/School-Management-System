#!/usr/bin/env bash
set -e

# Configure Apache port based on Render's PORT environment variable
PORT="${PORT:-80}"
sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Check and auto-generate APP_KEY if not present in environment
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is not set in environment. Generating application key..."
    php artisan key:generate --force
fi

# Ensure database directory and SQLite file exist
mkdir -p /var/www/html/database
if [ ! -f /var/www/html/database/database.sqlite ]; then
    echo "Creating database.sqlite file..."
    touch /var/www/html/database/database.sqlite
fi

# Set ownership and permissions for storage, bootstrap/cache, and database
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod 664 /var/www/html/database/database.sqlite || true

# Create storage symlink if missing
if [ ! -L /var/www/html/public/storage ]; then
    php artisan storage:link || true
fi

# Run database migrations and seeders
echo "Running database migrations and seeders..."
php artisan migrate --force --seed || php artisan migrate --force

# Run production caching optimizations
echo "Optimizing Laravel configuration and routes..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Start Apache in foreground
echo "Starting Apache web server on port ${PORT}..."
exec apache2-foreground
