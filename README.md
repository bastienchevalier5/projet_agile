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
git clone https://github.com/votre-utilisateur/cours-laravel.git
cd chemin/vers/votre/projet
```

### 2. Installer les dépendances

```bash
composer install
npm install
```

### 3. Configurer l'environnement

Copiez le fichier .env.example en .env et configurez les paramètres de votre environnement, notamment les informations de connexion à la base de données.

```bash
cp .env.example .env
```

### 4. Exécuter les miigrations

```bash
php artisan migrate
```

### 5. Compiler les assets Front-End

```bash
npm run dev
```


