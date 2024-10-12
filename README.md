# Application de Gestion des Absences

## Introduction

Cette application Laravel est conçue pour gérer les absences des utilisateurs. Elle permet aux utilisateurs de demander des absences et aux administrateurs de gérer ces demandes. Les motifs d'absence peuvent également être définis et gérés.

## Fonctionnalités

- **Gestion des Utilisateurs**: Création, modification et suppression des utilisateurs.
- **Gestion des Absences**: Les utilisateurs peuvent demander des absences et les administrateurs peuvent les valider ou non.
- **Gestion des Motifs**: Création, modification et suppression des motifs d'absence pour les administrateurs.
- **Notifications par Email**: Envoi de notifications par email aux administrrateurs pour les demandes d'absence.

## Prérequis

- PHP 8.0 ou supérieur
- Composer
- MySQL ou une autre base de données compatible avec Laravel
- Node.js et npm (pour les assets front-end)

## Installation

### 1. Cloner le Repository

```bash
cd chemin/vers/votre/projet
git clone https://github.com/bastienchevalier5/cours-laravel.git .
```


### 2. Configurer l'environnement

Copiez le fichier .env.example en .env

```bash
cp .env.example .env
```
Configurez les paramètres de votre environnement, notamment les informations de connexion à la base de données.

```php
// Changer le nom de l'application
APP_NAME='Gestion des absences'

// Changer le Timezone de l'application
APP_TIMEZONE='Europe/Paris'

// Changer l'url de  l'application
APP_URL=http://localhost

// Changer les informations sur la langue
APP_LOCALE=fr
APP_FAKER_LOCALE=fr_FR

// Changer les informations pour que cela corresponde à votre base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1 ou l'adresse de votre base de données
DB_PORT=3306
DB_DATABASE=nom_de_votre_base_de_donnees
DB_USERNAME=votre_nom_d'utilisateur
DB_PASSWORD=votre_mot_de_passe

```

### 3. Générer la clé de l'application

```bash
php artisan key:generate
```

### 4. Installer les dépendances

```bash
composer install
npm install
npm run build
npm run dev
```

### 5. Exécuter les migrations

```bash
php artisan migrate
```

### 6. Remplir la base de données

```bash
php artisan db:seed
```
### 7. Logins et mot de passes

Administrateur : 
Email : admin@admin.fr
Mot de passe : admin

Utilisateur :
Email : user@user.fr
Mot de passe : user


### 8. Accéder à l'application

Maintenant, vous devrez pouvoir atteindre l'application en allant sur l'url que vous avez indiqué.
