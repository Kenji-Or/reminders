# Reminders API - Configuration de développement local

## Configuration

Cette configuration utilise :
- **Docker** uniquement pour MySQL (base de données)
- **PHP serveur intégré** pour l'application (lancé manuellement)

## Démarrage rapide

### 1. Démarrer la base de données
```bash
docker-compose up -d db
```

### 2. Installer les dépendances (si pas déjà fait)
```bash
composer install
```

### 3. Lancer l'application PHP
```bash
cd src && php -S localhost:8080
```

## Accès à l'application

- **Application** : http://localhost:8080
- **Base de données** : localhost:3306

## Variables d'environnement

Les variables sont définies dans le fichier `.env` vous trouverez les valeurs suivantes à configurer dans ce fichier : `.env.example`

## Arrêter les services

```bash
# Arrêter la base de données
docker-compose down

# Arrêter PHP (Ctrl+C dans le terminal)
```

## Structure du projet

```
├── docker-compose.yml  # Configuration MySQL uniquement
├── .env               # Variables d'environnement
├── composer.json      # Dépendances PHP
├── sql/               # Scripts de création de la base de données
└── src/               # Code source PHP
    ├── index.php      # Point d'entrée de l'API
    ├── db.php         # Connexion base de données
    ├── Router/        # Système de routing
    └── Controllers/   # Contrôleurs
```
