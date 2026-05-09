#!/bin/bash
echo "Lancement du serveur avec limites d'upload augmentées (20M)..."
php -d upload_max_filesize=20M -d post_max_size=25M artisan serve --host=0.0.0.0 --port=8000
