# Laravel Homestead - Mon Application

Bienvenue dans mon application Laravel utilisant Homestead. Ce fichier `README.md` contient les informations essentielles pour installer, configurer et lancer ce projet en local avec Homestead.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre machine :

- [VirtualBox](https://www.virtualbox.org/)
- [Vagrant](https://www.vagrantup.com/)
- [Git](https://git-scm.com/)
- [Composer](https://getcomposer.org/)
- [Laravel Homestead](https://laravel.com/docs/11.x/homestead)

## Installation

### 1. Cloner le dépôt

```bash

cd mon-projet
git clone https://github.com/bastienchevalier5/cours-laravel.git

```

### 2. Installer les dépendances PHP avec Composer

```bash
composer install
```

### 3. Installer Laravel Homestead

Si Homestead n'est pas déjà installé globalement sur votre machine, exécutez la commande suivante :

```bash
vagrant box add laravel/homestead
```

Puis, dans votre projet, ajoutez le fichier Homestead en utilisant cette commande :

```bash
php vendor/bin/homestead make
```

### 4. Configuration Homestead

Ouvrez le fichier `Homestead.yaml` généré et configurez-le selon les besoins de votre projet. Exemple minimal :

```yaml
ip: "192.168.10.10"
memory: 2048
cpus: 2
provider: virtualbox

folders:
    - map: ~/chemin/vers/mon-projet
      to: /home/vagrant/code

sites:
    - map: homestead.test
      to: /home/vagrant/code/public

databases:
    - homestead
```

### 5. Ajouter l'entrée DNS locale

Ajoutez l'entrée suivante dans votre fichier `/etc/hosts` :

```bash
192.168.10.10 homestead.test
```

### 6. Lancer la machine virtuelle

Démarrez Homestead avec Vagrant :

```bash
vagrant up
```

Vous pouvez accéder à la machine virtuelle en utilisant la commande suivante :

```bash
vagrant ssh
```

### 7. Créer le fichier `.env`

Copiez le fichier `.env.example` et renommez-le en `.env` :

```bash
cp .env.example .env
```

Générez une nouvelle clé d'application Laravel :

```bash
php artisan key:generate
```

### 8. Migrer la base de données

Exécutez les migrations de la base de données à l'intérieur de la machine virtuelle :

```bash
php artisan migrate
```

## Utilisation

### Accès à l'application

Une fois Homestead démarré, accédez à l'application en ouvrant votre navigateur et en entrant l'URL suivante :

```
http://homestead.test
```

### Commandes artisan

Vous pouvez exécuter des commandes artisan à l'intérieur de la machine virtuelle :

```bash
vagrant ssh
cd /home/vagrant/code
php artisan [commande]
```

## Debugging

### Accéder aux logs

Les logs Laravel sont accessibles dans le répertoire `storage/logs` de votre projet. Si vous avez un problème avec Homestead ou la machine virtuelle, les logs de Vagrant peuvent également être utiles.

### Recharger la configuration Homestead

Si vous modifiez le fichier `Homestead.yaml`, assurez-vous de recharger la machine virtuelle pour appliquer les changements :

```bash
vagrant reload --provision
```

## Ressources supplémentaires

- [Documentation Laravel](https://laravel.com/docs)
- [Documentation Laravel Homestead](https://laravel.com/docs/11.x/homestead)

---

### Auteurs

- **Chevalier Bastien** - *Développeur principal* - [bastienchevalier5](https://github.com/bastienchevalier5)

---
