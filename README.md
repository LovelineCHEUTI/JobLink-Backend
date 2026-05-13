# JobLink — Backend API

API REST Laravel 11 pour l'application JobLink.

## Stack Technique
- Laravel 11 (PHP 8.2+)
- PostgreSQL 16
- Laravel Sanctum (authentification)

## Installation

### 1. Cloner le projet
```bash
git clone https://github.com/LovelineCHEUTI/JobLink-Backend.git
cd JobLink-Backend
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurer la base de données
Modifier `.env` :
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=joblink_db
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe
### 5. Créer la base de données PostgreSQL
```sql
CREATE DATABASE joblink_db;
```

### 6. Lancer les migrations et seeders
```bash
php artisan migrate --seed
```

### 7. Lancer le serveur
```bash
php artisan serve
```

L'API sera disponible sur `http://localhost:8000`

## Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | admin@joblink.com | Admin@1234 |
| Prestataire | provider1@test.com | Password123 |
| Prestataire | provider2@test.com | Password123 |
| Client | client@test.com | Password123 |

## Endpoints principaux

| Méthode | Route | Description |
|---------|-------|-------------|
| POST | /api/v1/auth/register | Inscription |
| POST | /api/v1/auth/login | Connexion |
| GET | /api/v1/providers | Liste prestataires |
| GET | /api/v1/client/categories | Catégories |
| POST | /api/v1/client/requests | Envoyer demande |
| GET | /api/v1/provider/dashboard | Dashboard prestataire |
| GET | /api/v1/admin/dashboard | Dashboard admin |

## Structure du projet
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   ├── Client/
│   │   ├── Provider/
│   │   ├── Admin/
│   │   └── Shared/
│   ├── Middleware/
│   └── Requests/
├── Models/
└── Services/
database/
├── migrations/
└── seeders/
routes/
└── api.php

