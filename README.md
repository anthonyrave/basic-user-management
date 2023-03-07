## Installation

Exécuter la commande suivante:

```bash
$ composer install
```

Lancement des migrations et ajout des utilisateurs par défaut :

```bash
$ php artisan migrate --seed
```

Cette commande aura pour effet de créer automatiquement un compte "Admin" ainsi que 5 comptes utilisateurs factices.

## Informations complémentaires

| Route          | Description                     |
|----------------|---------------------------------|
| `/login`       | Connexion (client)              |
| `/register`    | Création de compte (client)     |
| `/profile`     | Informations du compte (client) |
| `/admin/login` | Connexion (admin)               |
| `/admin`       | Liste des utilisateurs (admin)  |

Les informations de connexion à l'interface d'administration sont:

| User              | Password |
|-------------------|----------|
| admin@example.com | admin    |

(Ces informations sont pré-remplies volontairement pour simplifier les tests).
