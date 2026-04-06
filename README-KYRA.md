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
| `/manifestes` | `pages/manifestes` | Liste des manifestes publiés |
| `/blog` | `blog/index` | Liste des articles de blog |
| `/blog/{slug}` | `blog/show` | Article de blog |
| `/sitemap.xml` | — | Sitemap XML généré dynamiquement |

### Espace membres

| Route | Description |
|---|---|
| `/member/login` | Connexion membre |
| `POST /member/login` | Authentification |
| `/member/register` | Formulaire d'inscription |
| `POST /member/register` | Soumission inscription |
| `/member/verify-email/{token}` | Vérification email |
| `POST /member/logout` | Déconnexion |
| `/member/profile` | Profil membre (auth requise) |

### Panneau admin

| Route | Description |
|---|---|
| `/admin` | Dashboard (messages + stats + statut maintenance) |
| `/admin/login` | Authentification |
| `/admin/messages` | Liste des messages reçus |
| `/admin/messages/{id}` | Détail + réponse message |
| `/admin/settings` | Configuration complète |
| `/admin/users` | Gestion des utilisateurs/membres |
| `/admin/profile` | Profil & tokens API |
| `/admin/stats` | Statistiques de visites |
| `/admin/manifeste` | CRUD manifestes |
| `/admin/blog` | CRUD articles de blog |
| `/admin/toolbox` | Outils admin (email test, artisan) |
| `/admin/logs` | Visionneuse de logs |
| `/admin/doc/api` | Documentation API |

### API REST (v1)

Base URL : `/api/v1`

| Méthode | Route | Auth | Description |
|---|---|---|---|
| `GET` | `/manifestes` | — | Manifestes publiés (public) |
| `GET` | `/manifestes/all` | Sanctum admin | Tous les manifestes |
| `POST` | `/manifestes` | Sanctum admin | Créer un manifeste |
| `GET` | `/manifestes/{id}` | Sanctum admin | Détail manifeste |
| `PUT` | `/manifestes/{id}` | Sanctum admin | Modifier manifeste |
| `DELETE` | `/manifestes/{id}` | Sanctum admin | Supprimer manifeste |
| `PATCH` | `/manifestes/{id}/pin` | Sanctum admin | Épingler |
| `PATCH` | `/manifestes/{id}/unpin` | Sanctum admin | Désépingler |
| `GET` | `/posts` | Sanctum admin | Liste articles |
| `POST` | `/posts` | Sanctum admin | Créer article |
| `GET` | `/posts/{id}` | Sanctum admin | Détail article |
| `PUT` | `/posts/{id}` | Sanctum admin | Modifier article |
| `DELETE` | `/posts/{id}` | Sanctum admin | Supprimer article |
| `PATCH` | `/posts/{id}/publish` | Sanctum admin | Publier |
| `PATCH` | `/posts/{id}/unpublish` | Sanctum admin | Dépublier |
| `POST` | `/posts/{id}/media` | Sanctum admin | Upload média |
| `PATCH` | `/posts/{id}/media/{m}/featured` | Sanctum admin | Définir image principale |
| `DELETE` | `/posts/{id}/media/{m}` | Sanctum admin | Supprimer média |

Authentification API : token Bearer Sanctum, généré depuis `/admin/profile`.

---

## Fonctionnalités clés

### Formulaire de contact
- Validation Laravel backend (name, email, subject, message)
- **Captcha ALTCHA** — Proof of Work SHA-256, 100% self-hosted, aucun appel externe
- Sauvegarde en base (`contact_messages`)
- Notification email configurable
- Activable/désactivable depuis l'admin
- Message de succès personnalisable depuis l'admin

### Blog
- CRUD articles (titre, contenu, slug, résumé)
- Upload médias avec image principale (featured image) et position
- Publier / dépublier
- Accessible via admin web et API REST

### Manifestes
- CRUD manifestes publiables
- Système d'épinglage (pin/unpin)
- Route publique + API REST

### Système membres
- Inscription avec modes d'activation configurables : `auto` (immédiat), `email` (vérification), `admin` (approbation manuelle)
- Vérification email par token
- Approbation manuelle depuis `/admin/users`
- Inscriptions activables/désactivables depuis l'admin
- Message personnalisable si inscriptions fermées

### Mode Sommeil Profond (maintenance)
- Activable depuis `/admin/settings`
- Page de maintenance Kyra-stylée avec statut animé (analyse / vérification / synchronisation…)
- Message personnalisable
- Les routes `/admin/*` restent accessibles
- Retourne 503 JSON pour les requêtes API

### Panel admin
- Auth Laravel native
- Lecture / marquage lu-non lu / suppression des messages
- Réponses aux messages avec pièces jointes
- Gestion des settings via table `settings` (clé/valeur)
- Configuration mail runtime (sans redémarrer le serveur)
- Gestion des utilisateurs/membres (créer, éditer, approuver, supprimer)
- Statistiques de visites
- Toolbox : test email, commandes artisan
- Visionneuse de logs
- Profil admin + gestion tokens API Sanctum

### Settings dynamiques

Les settings runtime sont stockés en base et chargés dans `AppServiceProvider` :

| Clé | Défaut | Description |
|---|---|---|
| `form_enabled` | `true` | Active/désactive le formulaire de contact |
| `form_success_message` | `...` | Message affiché après envoi |
| `mail_to` | `hello@imkyra.be` | Adresse de réception |
| `mail_mailer` | `smtp` | Driver mail |
| `mail_host` | `127.0.0.1` | Hôte SMTP |
| `mail_port` | `25` | Port SMTP |
| `mail_from_address` | `hello@imkyra.be` | Expéditeur |
| `mail_from_name` | `KYRA` | Nom expéditeur |
| `maintenance_enabled` | `false` | Active le mode sommeil profond |
| `maintenance_message` | `...` | Message affiché sur la page de maintenance |
| `member_registration_enabled` | `true` | Active/désactive les inscriptions membres |
| `member_registration_disabled_message` | `...` | Message si inscriptions fermées |
| `member_registration_approval` | `auto` | Mode activation : `auto`, `email`, `admin` |

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
