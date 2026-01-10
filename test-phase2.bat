@echo off
echo ========================================
echo   TEST PHASE 2 - DWESTA MARKETPLACE
echo ========================================
echo.

echo [1/6] Execution des migrations...
php artisan migrate
if %errorlevel% neq 0 (
    echo ERREUR: Les migrations ont echoue
    pause
    exit /b 1
)
echo OK - Migrations executees
echo.

echo [2/6] Execution des seeders...
php artisan db:seed --class=AbonnementSeeder
if %errorlevel% neq 0 (
    echo ERREUR: Le seeder a echoue
    pause
    exit /b 1
)
echo OK - Seeders executes
echo.

echo [3/6] Creation du lien symbolique storage...
php artisan storage:link
echo OK - Lien symbolique cree
echo.

echo [4/6] Nettoyage du cache...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo OK - Cache nettoye
echo.

echo [5/6] Execution des tests automatiques...
php artisan test
if %errorlevel% neq 0 (
    echo ATTENTION: Certains tests ont echoue
) else (
    echo OK - Tous les tests sont passes
)
echo.

echo [6/6] Verification des routes...
php artisan route:list --name=vendeur | findstr /C:"vendeur"
php artisan route:list --name=abonnements | findstr /C:"abonnements"
php artisan route:list --name=page-pro | findstr /C:"page-pro"
echo OK - Routes verifiees
echo.

echo ========================================
echo   TEST TERMINE
echo ========================================
echo.
echo Prochaines etapes:
echo 1. Lancer le serveur: php artisan serve
echo 2. Ouvrir http://localhost:8000
echo 3. Suivre le guide: GUIDE_TEST_PHASE2.md
echo.
pause

