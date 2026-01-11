<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Affiche les annonces d'une catégorie
     */
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('actif', true)
            ->with(['parent', 'enfantsActifs.enfantsActifs'])
            ->firstOrFail();

        // Charger les annonces de cette catégorie et de ses enfants
        $categoryIds = $category->getAllDescendantIds();
        
        $annonces = Annonce::publiees()
            ->whereIn('categorie_id', $categoryIds)
            ->with(['photos', 'category', 'vendeur.user', 'options'])
            ->latest('publiee_le')
            ->paginate(24);

        return view('categories.show', compact('category', 'annonces'));
    }
}
