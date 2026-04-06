# KYRA — Site public

Site web public de **Kyra**, daemon IA local. Interface éditoriale dark/terminal construite avec Laravel 12 + Bootstrap 5 + Vite.

---

## Stack technique

| Couche | Technologie |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Bootstrap 5.3, Vite 8 |
| Base de données | SQLite (fichier local) |
| Mail | SMTP configurable via admin |
| Captcha | ALTCHA (Proof of Work, self-hosted) |
| Assets | Vite — build statique dans `public/build/` |

---

## Installation locale

```bash
git clone <repo>
cd kyra-laravel-site

# Dépendances PHP
composer install

# Dépendances JS
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
php artisan migrate
php artisan db:seed          # crée l'admin + settings par défaut

# Assets
npm run build

# Serveur de développement
php artisan serve
# ou en parallèle (hot reload CSS/JS) :
php artisan serve &
npm run dev
```

### Accès admin par défaut

Voir `database/seeders/AdminUserSeeder.php` pour les identifiants initiaux.  
Panneau : `/admin`

---

## Structure des routes publiques

| Route | Vue | Description |
|---|---|---|
| `/` | `pages/home` | Hero — système & capacités |
| `/about` | `pages/about` | Identité & manifeste |
| `/signal` | `pages/signal` | Médias, logs, signaux |
| `/protocole` | `pages/protocole` | Protocoles opérationnels |
| `/contact` | `pages/contact` | Statut & formulaire de contact |
| `POST /contact` | — | Soumission formulaire (ALTCHA + validation) |
| `/sitemap.xml` | — | Sitemap XML généré dynamiquement |

### Panneau admin

| Route | Description |
|---|---|
| `/admin` | Dashboard (messages + stats) |
| `/admin/messages` | Liste des messages reçus |
| `/admin/messages/{id}` | Détail message |
| `/admin/settings` | Configuration (mail, formulaire, messages) |
| `/admin/login` | Authentification |

---

## Fonctionnalités clés

### Formulaire de contact
- Validation Laravel backend (name, email, subject, message)
- **Captcha ALTCHA** — Proof of Work SHA-256, 100% self-hosted, aucun appel externe
- Sauvegarde en base (`contact_messages`)
- Notification email configurable
- Activable/désactivable depuis l'admin
- Message de succès personnalisable depuis l'admin

### Panel admin
- Auth Laravel native
- Lecture / marquage lu-non lu / suppression des messages
- Gestion des settings via table `settings` (clé/valeur)
- Configuration mail runtime (sans redémarrer le serveur)

### Settings dynamiques

Les settings runtime sont stockés en base et chargés dans `AppServiceProvider` :

| Clé | Défaut | Description |
|---|---|---|
| `form_enabled` | `true` | Active/désactive le formulaire |
| `form_success_message` | `...` | Message affiché après envoi |
| `mail_to` | `hello@imkyra.be` | Adresse de réception |
| `mail_mailer` | `smtp` | Driver mail |
| `mail_host` | `127.0.0.1` | Hôte SMTP |
| `mail_port` | `25` | Port SMTP |
| `mail_from_address` | `hello@imkyra.be` | Expéditeur |
| `mail_from_name` | `KYRA` | Nom expéditeur |

---

## Variables d'environnement spécifiques

```dotenv
# ALTCHA Proof-of-Work captcha (self-hosted)
ALTCHA_HMAC_KEY=<clé_hex_64_chars>

# Optionnel — SHA-1 ou SHA-512 (défaut: SHA-256)
# ALTCHA_ALGORITHM="SHA-256"
```

Générer une clé HMAC :
```bash
php -r "echo bin2hex(random_bytes(32)) . PHP_EOL;"
```

---

## Build & déploiement

```bash
# Build production
npm run build

# Optimisations Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations en production
php artisan migrate --force
```

Les assets compilés sont dans `public/build/` — le manifeste Vite est lu automatiquement par `@vite()`.

---

## Identité visuelle

- **Palette** : fond `#050d12`, cyan `#00c8ff`, accent `#00ffcc`, pink `#ff3366`
- **Polices** : Orbitron (titres), Share Tech Mono (terminal), Rajdhani (corps) — toutes hébergées localement dans `public/fonts/`
- **Effets** : scanlines CSS, grille de fond, glows cyan
- **Layout** : Bootstrap 5 + variables CSS custom dans `resources/css/app.css`

---

## Tests

```bash
php artisan test
```

Tests dans `tests/Feature/` et `tests/Unit/`.  
Pour les routes protégées par ALTCHA, utiliser le bypass de test :

```php
// phpunit.xml ou dans le test
config(['altcha.testing_bypass' => 'valid']);
```
