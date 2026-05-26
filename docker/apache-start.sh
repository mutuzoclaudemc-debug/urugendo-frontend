#!/bin/bash
set -e

# Render provides PORT; Apache must listen on it
PORT="${PORT:-80}"

# Cache Laravel config at runtime (env vars are injected by Render)
php /var/www/html/artisan config:cache
php /var/www/html/artisan route:cache
php /var/www/html/artisan view:cache

# Update Apache to listen on $PORT
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf

apache2-foreground
