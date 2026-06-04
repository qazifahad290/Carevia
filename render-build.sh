#!/usr/bin/env bash
set -e

echo "==> Installing PHP dependencies"
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "==> Installing Node dependencies"
npm ci --no-audit --no-fund || npm install --no-audit --no-fund

echo "==> Building front-end assets"
npm run build

echo "==> Generating APP_KEY if missing"
php artisan key:generate --force

echo "==> Caching config/routes/views"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Storage symlink"
php artisan storage:link || true

echo "==> Running migrations and seeding"
php artisan migrate --force --seed

echo "==> Build complete"
