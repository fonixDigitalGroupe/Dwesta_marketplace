<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnnonceResource;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    /**
     * Liste paginée des annonces publiées (filtres : recherche, catégorie, famille).
     */
    public function index(Request $request)
    {
        $query = Annonce::publiees()
            ->with(['category', 'vendeur', 'photos'])
            ->latest('publiee_le');

        if ($search = $request->get('search')) {
            $query->where('titre', 'like', "%{$search}%");
        }

        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->get('categorie_id'));
        }

        if ($famille = $request->get('famille')) {
            $query->whereHas('category', fn ($q) => $q->where('famille', $famille));
        }

        return AnnonceResource::collection($query->paginate(20));
    }

    /**
     * Détail d'une annonce.
     */
    public function show(Annonce $annonce)
    {
        $annonce->load(['category', 'vendeur.user', 'photos', 'avisApprouves']);
        $annonce->incrementerVues();

        return new AnnonceResource($annonce);
    }
}
