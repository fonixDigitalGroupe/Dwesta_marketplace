<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    /**
     * Affiche un document de manière sécurisée
     * Seuls les administrateurs peuvent accéder aux documents
     */
    public function show(Request $request, string $path)
    {
        // Décoder le chemin
        $decodedPath = base64_decode($path);
        
        if (!$decodedPath) {
            abort(404);
        }

        // Vérifier que l'utilisateur est authentifié et est admin
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé.');
        }

        // Vérifier que le fichier existe
        if (!Storage::disk('private')->exists($decodedPath)) {
            abort(404, 'Document introuvable.');
        }

        // Retourner le fichier
        return Storage::disk('private')->response($decodedPath);
    }
}
