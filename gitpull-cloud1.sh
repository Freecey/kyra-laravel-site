#!/usr/bin/env bash
# ═══════════════════════════════════════════════════════════
#  gitpull-cloud1.sh — Déploiement en production imkyra.be
#  Usage : bash gitpull-cloud1.sh
# ═══════════════════════════════════════════════════════════

set -e  # Arrête le script à la première erreur

SITE_DIR="/var/www/imkyra.be/web/kyra-laravel-site"
WEB_USER="web28"
WEB_GROUP="client1"

echo "▶ [1/7] Git pull..."
cd "$SITE_DIR"
git pull

echo "▶ [2/7] Composer install (no-dev, optimisé)..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "▶ [3/7] NPM install..."
npm ci --prefer-offline

echo "▶ [4/7] Vite build..."
npm run build

echo "▶ [5/7] Artisan optimize + caches..."
php artisan optimize
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache

echo "▶ [6/7] Permissions..."
chown "$WEB_USER":"$WEB_GROUP" "$SITE_DIR"/ -R

echo "▶ [7/7] Génération WebP si nouvelles images..."
php artisan images:webp

echo ""
echo "✔  Déploiement terminé — $(date '+%Y-%m-%d %H:%M:%S')"
