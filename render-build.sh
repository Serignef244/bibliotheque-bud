#!/usr/bin/env bash
# Quitte le script s'il y a une erreur
set -e

echo "Installation des dépendances PHP..."
composer install --no-dev --optimize-autoloader

echo "Installation des dépendances Node.js et compilation..."
npm install
npm run build

echo "Nettoyage du cache Laravel..."
php artisan optimize:clear
php artisan view:cache

echo "Exécution des migrations..."
php artisan migrate --force

echo "Build terminé avec succès !"
