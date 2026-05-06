#!/usr/bin/env bash
set -euo pipefail

PORT="${PORT:-80}"

# Render sets PORT (e.g. 10000); Apache must listen on it.
if grep -q '^Listen ' /etc/apache2/ports.conf; then
  sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
else
  echo "Listen ${PORT}" >> /etc/apache2/ports.conf
fi

sed -i "s/<VirtualHost \\*:[0-9]*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

cd /var/www/html

php artisan package:discover --ansi --no-interaction

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force

php artisan db:seed --class=Database\\Seeders\\AdminUserSeeder --force

php artisan storage:link --force --no-interaction || true

exec apache2-foreground
