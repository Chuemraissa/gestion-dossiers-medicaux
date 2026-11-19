# Gestion des dossiers médicaux des patients

Application web Laravel 11 pour la gestion d'un centre de santé : patients, paramètres et antécédents,
consultations, ordonnances, examens, médicaments, rendez-vous et planning.

## Rôles et accès

Les rôles et ce que chacun peut faire sont enregistrés en base de données :
- table `roles` : les rôles (code, nom affiché, rôle patient ou non) ;
- table `role_acces` : les accès de chaque rôle (ex. `patients`, `prescription`).

Les valeurs de départ sont chargées par `php artisan db:seed` (fichier `database/seeders/RoleSeeder.php`,
qui contient aussi la liste des accès disponibles). Ensuite, elles se modifient directement en base.

Par défaut :

| Rôle | Accès |
|------|-------|
| Administrateur | Tout, dont la gestion des comptes du personnel |
| Médecin | Patients, consultations, ordonnances (rédaction), examens, médicaments, rendez-vous |
| Infirmière | Patients, consultations, ordonnances (lecture), examens (lecture), médicaments, rendez-vous |
| Laborantin | Ordonnances (lecture), examens, médicaments (lecture) |
| Pharmacien | Médicaments |
| Chargé d'accueil | Patients |
| Patient | Son propre dossier médical uniquement |

## Listes de choix

Les listes des formulaires (statuts de rendez-vous, types d'examen, de consultation et d'antécédent,
groupes sanguins, tarifs de consultation) sont dans la table `listes`.
Valeurs de départ : `database/seeders/ListeSeeder.php`, chargées par `php artisan db:seed`.

## Langues

Une langue = un dossier dans `lang/` (avec `messages.php`). Le menu « Langue » les affiche automatiquement.
Langue par défaut : `APP_LOCALE` dans `.env`.

## Prérequis

- PHP 8.2 ou plus
- Composer
- MySQL ou MariaDB

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Dans `.env`, renseigner :
- la base de données (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) ;
- le premier administrateur (`ADMIN_EMAIL`, `ADMIN_PASSWORD`).

Puis créer les tables et l'administrateur :

```bash
php artisan migrate
php artisan db:seed
```

`db:seed` charge les rôles puis crée l'administrateur.

## Lancer l'application

```bash
php artisan serve
```

Ouvrir http://localhost:8000 et se connecter avec le compte administrateur.

Les rappels de rendez-vous (envoyés 5 h avant) passent par une file d'attente.
Pour qu'ils partent, lancer dans un second terminal :

```bash
php artisan queue:work
```

## E-mails

- `MAIL_MAILER=log` : les e-mails ne partent pas, ils sont écrits dans `storage/logs/laravel.log` (pour les tests).
- `MAIL_MAILER=smtp` : envoi réel. Avec Gmail, utiliser un mot de passe d'application.

Si le serveur d'e-mails ne répond pas, l'application continue de fonctionner. L'erreur est notée dans le journal.

## Tests

```bash
php artisan test
```
