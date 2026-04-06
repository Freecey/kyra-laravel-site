#!/usr/bin/env bash
# ═══════════════════════════════════════════════════════════
#  gitpull-cloud1.sh — Déploiement en production imkyra.be
#  Usage : bash gitpull-cloud1.sh
# ═══════════════════════════════════════════════════════════

set -e

SITE_DIR="/var/www/imkyra.be/web/kyra-laravel-site"
WEB_USER="web28"
WEB_GROUP="client1"

# Couleurs
CYAN='\033[0;36m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
MAGENTA='\033[0;35m'
BOLD='\033[1m'
RESET='\033[0m'

step() { echo -e "\n${CYAN}${BOLD}$1${RESET}"; }
ok()   { echo -e "${GREEN}  ✔  $1${RESET}"; }

clear
echo -e "${MAGENTA}${BOLD}"
echo "  ██╗  ██╗██╗   ██╗██████╗  █████╗ "
echo "  ██║ ██╔╝╚██╗ ██╔╝██╔══██╗██╔══██╗"
echo "  █████╔╝  ╚████╔╝ ██████╔╝███████║"
echo "  ██╔═██╗   ╚██╔╝  ██╔══██╗██╔══██║"
echo "  ██║  ██╗   ██║   ██║  ██║██║  ██║"
echo "  ╚═╝  ╚═╝   ╚═╝   ╚═╝  ╚═╝╚═╝  ╚═╝"
echo -e "${RESET}"
echo -e "${CYAN}${BOLD}  ⌬  Déploiement production — imkyra.be${RESET}"
echo -e "${YELLOW}  $(date '+%Y-%m-%d %H:%M:%S')${RESET}"
echo -e "  ─────────────────────────────────────"

cd "$SITE_DIR"

step "🔀  [1/7] Git pull..."
git pull
ok "Dépôt à jour"

step "📦  [2/7] Composer install..."
composer install --no-dev --optimize-autoloader --no-interaction
ok "Dépendances PHP installées"

step "🧶  [3/7] NPM install..."
npm ci --prefer-offline
ok "Dépendances JS installées"

step "⚡  [4/7] Vite build..."
npm run build
ok "Assets compilés"

step "🚀  [5/7] Laravel optimize..."
php artisan optimize
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
ok "Cache Laravel rechargé"

step "🔑  [6/7] Permissions..."
chown "$WEB_USER":"$WEB_GROUP" "$SITE_DIR"/ -R
ok "Propriétaire : ${WEB_USER}:${WEB_GROUP}"

step "🖼️   [7/7] Génération WebP..."
php artisan images:webp
ok "Images optimisées"

echo ""
echo -e "${GREEN}${BOLD}  ════════════════════════════════════${RESET}"
echo -e "${GREEN}${BOLD}  ✅  Déploiement terminé avec succès !${RESET}"
echo -e "${GREEN}${BOLD}  ════════════════════════════════════${RESET}"
echo -e "${YELLOW}  ⏱  $(date '+%Y-%m-%d %H:%M:%S')${RESET}\n"
