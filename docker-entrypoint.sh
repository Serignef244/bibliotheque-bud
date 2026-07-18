#!/bin/bash
set -e

echo "Optimisation de l'application..."
php artisan optimize:clear
php artisan view:cache
php artisan config:cache
php artisan route:cache

echo "Exécution des migrations de la base de données..."
php artisan migrate --force

echo "Démarrage du serveur Apache..."
# Passe la main à la commande spécifiée dans le CMD du Dockerfile (apache2-foreground)
exec "$@"
