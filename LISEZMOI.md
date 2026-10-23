# LogeEtudiant — Installation

Ces fichiers se placent dans un projet Laravel neuf (Laravel 11 ou 12).

## 1. Créer le projet
    composer create-project laravel/laravel logeetudiant
    cd logeetudiant

## 2. Copier les fichiers
Copier les dossiers `app`, `database`, `resources`, `routes` et `public` de ce zip
dans le projet, en acceptant de **remplacer** les fichiers existants
(notamment `0001_01_01_000000_create_users_table.php`, `User.php`, `web.php`, `DatabaseSeeder.php`).

## 3. Base de données
Dans `.env` (MySQL par exemple) :
    DB_CONNECTION=mysql
    DB_DATABASE=logeetudiant
    DB_USERNAME=root
    DB_PASSWORD=

Puis :
    php artisan migrate:fresh --seed
    php artisan serve

## Comptes de test (mot de passe : password)
- Propriétaire : proprio@test.com
- Étudiant : etudiant@test.com
