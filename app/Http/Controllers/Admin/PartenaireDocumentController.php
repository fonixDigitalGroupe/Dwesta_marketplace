<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PartenaireDocumentController extends Controller
{
    /**
     * Sert un document téléversé via la PWA partenaire (karnou-pwa).
     *
     * Les fichiers vivent sur le disque "public" de karnou-pwa
     * (storage/app/public/partenaire/...). Le hub partage la base de données
     * mais pas le storage : on lit donc le fichier directement sur le disque
     * partagé du serveur et on le renvoie via cette route admin authentifiée
     * (les pièces KYC ne sont ainsi jamais exposées publiquement).
     */
    public function show(string $path)
    {
        $path = ltrim($path, '/');

        // Sécurité : uniquement les fichiers partenaire/, pas de remontée de dossier.
        abort_unless(str_starts_with($path, 'partenaire/'), 404);
        abort_if(str_contains($path, '..'), 404);

        $base = config('services.partenaire.path') ?: base_path('../karnou-pwa/storage/app/public');
        $full = rtrim($base, '/') . '/' . $path;

        abort_unless(is_file($full), 404);

        return response()->file($full);
    }
}
