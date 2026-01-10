#!/bin/bash

echo "========================================"
echo "  TEST PHASE 2 - DWESTA MARKETPLACE"
echo "========================================"
echo ""

echo "[1/6] Execution des migrations..."
php artisan migrate
if [ $? -ne 0 ]; then
    echo "ERREUR: Les migrations ont échoué"
    exit 1
fi
echo "OK - Migrations exécutées"
echo ""

echo "[2/6] Execution des seeders..."
php artisan db:seed --class=AbonnementSeeder
if [ $? -ne 0 ]; then
    echo "ERREUR: Le seeder a échoué"
    exit 1
fi
echo "OK - Seeders exécutés"
echo ""

echo "[3/6] Création du lien symbolique storage..."
php artisan storage:link
echo "OK - Lien symbolique créé"
echo ""

echo "[4/6] Nettoyage du cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo "OK - Cache nettoyé"
echo ""

echo "[5/6] Execution des tests automatiques..."
php artisan test
if [ $? -ne 0 ]; then
    echo "ATTENTION: Certains tests ont échoué"
else
    echo "OK - Tous les tests sont passés"
fi
echo ""

echo "[6/6] Vérification des routes..."
php artisan route:list --name=vendeur | grep -q "vendeur" && echo "Routes vendeur: OK"
php artisan route:list --name=abonnements | grep -q "abonnements" && echo "Routes abonnements: OK"
php artisan route:list --name=page-pro | grep -q "page-pro" && echo "Routes page-pro: OK"
echo ""

echo "========================================"
echo "  TEST TERMINÉ"
echo "========================================"
echo ""
echo "Prochaines étapes:"
echo "1. Lancer le serveur: php artisan serve"
echo "2. Ouvrir http://localhost:8000"
echo "3. Suivre le guide: GUIDE_TEST_PHASE2.md"
echo ""

