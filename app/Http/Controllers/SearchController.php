<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Affiche les résultats de la recherche avec filtres
     */
    public function index(Request $request)
    {
        $query = Annonce::publiees()->with(['photos', 'category', 'vendeur.user', 'vendeur.professionnel', 'options', 'produit', 'vehicule', 'avisApprouves']);
        $category = null;

        // Recherche textuelle intelligente
        $searchTerm = $request->q ?? $request->search;
        if ($searchTerm) {
            // Nettoyage et découpage du terme en mots-clés (min 2 lettres)
            $keywords = collect(explode(' ', $searchTerm))
                ->filter(fn($word) => strlen($word) >= 2)
                ->map(fn($word) => trim($word))
                ->all();

            if (!empty($keywords)) {
                $query->where(function($q) use ($keywords) {
                    foreach ($keywords as $word) {
                        $q->where(function($sq) use ($word) {
                            $sq->where('titre', 'LIKE', "%{$word}%")
                              ->orWhere('description', 'LIKE', "%{$word}%")
                              ->orWhereHas('category', function($cq) use ($word) {
                                  $cq->where('nom', 'LIKE', "%{$word}%");
                              })
                              ->orWhereHas('vendeur.professionnel', function($vq) use ($word) {
                                  $vq->where('nom_entreprise', 'LIKE', "%{$word}%");
                              });
                        });
                    }
                });
            }
        }

        // Filtre par catégorie
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $category->load('filters');
                $query->whereIn('categorie_id', $category->descendantsAndSelf()->pluck('id'));
            }
        }

        // Filtre par prix
        if ($request->filled('min_prix')) {
            $query->where('prix', '>=', $request->min_prix);
        }
        if ($request->filled('max_prix')) {
            $query->where('prix', '<=', $request->max_prix);
        }

        // Filtre par état (si applicable au type produit)
        if ($request->filled('etat')) {
            $etats = is_array($request->etat) ? $request->etat : [$request->etat];
            $query->where(function($q) use ($etats) {
                $q->whereHas('produit', function($sq) use ($etats) {
                    $sq->whereIn('etat', $etats);
                })->orWhereHas('vehicule', function($sq) use ($etats) {
                    $sq->whereIn('etat', $etats);
                });
            });
        }

        // Filtres Spécifiques Immobilier
        if ($request->category == 'immobilier' || str_contains($request->category ?? '', 'immobilier')) {
            if ($request->filled('pieces')) {
                $query->whereHas('immobilier', function($q) use ($request) {
                    $q->where('pieces', '>=', $request->pieces);
                });
            }
            if ($request->filled('surface_min')) {
                $query->whereHas('immobilier', function($q) use ($request) {
                    $q->where('surface', '>=', $request->surface_min);
                });
            }
            if ($request->filled('type_transaction')) {
                $query->whereHas('immobilier', function($q) use ($request) {
                    $q->where('type_transaction', $request->type_transaction);
                });
            }
        }

        // Filtres Spécifiques Véhicules
        if ($request->category == 'vehicules' || str_contains($request->category ?? '', 'vehicule')) {
            if ($request->filled('marque')) {
                $query->whereHas('vehicule', function($q) use ($request) {
                    $q->where('marque', 'LIKE', "%{$request->marque}%");
                });
            }
            if ($request->filled('km_max')) {
                $query->whereHas('vehicule', function($q) use ($request) {
                    $q->where('kilometrage', '<=', $request->km_max);
                });
            }
            if ($request->filled('boite')) {
                $query->whereHas('vehicule', function($q) use ($request) {
                    $q->where('boite_vitesse', $request->boite);
                });
            }
        }

        // Filtre par type de vendeur (Pro/Particulier)
        if ($request->filled('vendeur_type')) {
            $vendeurType = $request->vendeur_type;
            $query->whereHas('vendeur', function($q) use ($vendeurType) {
                $q->where('type', $vendeurType);
            });
        }

        // Filtre par Promotion (Pour les bannières)
        if ($request->has('promo') || $request->has('promotion')) {
            $query->enPromotion();
        }
        
        // Filtres Dynamiques (Attributs/Critères)
        if ($request->filled('f') && is_array($request->f)) {
            foreach ($request->f as $filterSlug => $values) {
                if (!empty($values)) {
                    $query->whereHas('filteredAttributes', function($q) use ($filterSlug, $values) {
                        $q->whereHas('filter', function($sq) use ($filterSlug) {
                            $sq->where('slug', $filterSlug);
                        })->whereIn('valeur', is_array($values) ? $values : [$values]);
                    });
                }
            }
        }

        // Filtre par mode d'expédition
        if ($request->filled('shipping')) {
            $shippingMethods = is_array($request->shipping) ? $request->shipping : [$request->shipping];
            $query->whereIn('type_livraison', $shippingMethods);
        }

        // Tri
        $sort = $request->get('sort', 'relevance');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('prix', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('prix', 'desc');
                break;
            case 'newest':
                $query->orderBy('publiee_le', 'desc');
                break;
            case 'vues_desc':
                $query->orderBy('vues', 'desc');
                break;
            default:
                // Priorité : 1) Sponsorisé (À la une) | 2) Vendeurs pro | 3) Vues
                $query
                    ->leftJoin('vendeurs', 'vendeurs.id', '=', 'annonces.vendeur_id')
                    ->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM annonce_options WHERE annonce_id = annonces.id AND a_la_une = 1) THEN 0 ELSE 1 END")
                    ->orderByRaw("CASE WHEN vendeurs.type = 'professionnel' THEN 0 ELSE 1 END")
                    ->orderBy('annonces.vues', 'desc')
                    ->select('annonces.*');
                break;
        }

        $annonces = $query->paginate(20)->withQueryString();

        // Tentative de trouver le "vrai mot" (Correction intelligente du titre)
        $bestMatch = $searchTerm;
        if ($annonces->total() > 0 && $searchTerm) {
            $firstProduct = $annonces->first();
            
            // 1. Chercher si le terme ressemble énormément à une catégorie
            $matchingCategory = Category::where('actif', true)
                ->get()
                ->filter(function($c) use ($searchTerm) {
                    $similarity = 0;
                    similar_text(strtolower($searchTerm), strtolower($c->nom), $percentage);
                    return $percentage > 85; 
                })->first();

            if ($matchingCategory) {
                $bestMatch = $matchingCategory->nom;
            } 
            // 2. Sinon, si c'est un produit très spécifique, on peut suggérer le titre propre
            elseif ($annonces->total() < 5) {
                $bestMatch = $firstProduct->titre;
            }
        }
        
        // Détection de la catégorie "active" pour la sidebar
        $activeCategory = $category;
        // Ne pas forcer la catégorie en fonction du 1er résultat s'il s'agit d'une recherche globale ou d'un tri global (Top des produits)
        if (!$activeCategory && $annonces->total() > 0 && !request('q') && request('sort') !== 'vues_desc') {
            // Conservation du comportement uniquement pour les autres cas potentiels
            $activeCategory = $annonces->first()->category;
        }

        // Données pour la sidebar de filtres (Logique de tunnel de catégorie)
        $sidebarCategories = collect();
        $sidebarParent = null;

        if ($activeCategory) {
            if ($activeCategory->parent_id === null) {
                // Si c'est une catégorie racine (Niveau 1)
                $sidebarParent = $activeCategory;
                $sidebarCategories = $activeCategory->enfantsActifs;
            } else {
                // Si c'est une catégorie de Niveau 2 ou 3
                $sidebarParent = $activeCategory->parent;
                $sidebarCategories = $sidebarParent->enfantsActifs;
            }
        } else {
            // Aucune catégorie détectée : on affiche les racines
            $sidebarCategories = Category::whereNull('parent_id')->actives()->get();
        }

        // Calcul des comptes réels par catégorie pour la sidebar
        foreach ($sidebarCategories as $sideCat) {
            $sideCat->real_count = (clone $query)->whereIn('categorie_id', $sideCat->descendantsAndSelf()->pluck('id'))->count();
        }
        
        // Calcul des comptes pour la sidebar (États)
        $countsEtats = [
            'neuf' => (clone $query)->where(function($q) {
                $q->whereHas('produit', fn($sq) => $sq->where('etat', 'neuf'))
                  ->orWhereHas('vehicule', fn($sq) => $sq->where('etat', 'neuf'));
            })->count(),
            'occasion' => (clone $query)->where(function($q) {
                $q->whereHas('produit', fn($sq) => $sq->where('etat', 'occasion'))
                  ->orWhereHas('vehicule', fn($sq) => $sq->where('etat', 'occasion'));
            })->count(),
            'reconditionne' => (clone $query)->where(function($q) {
                $q->whereHas('produit', fn($sq) => $sq->where('etat', 'reconditionne'))
                  ->orWhereHas('vehicule', fn($sq) => $sq->where('etat', 'reconditionne'));
            })->count(),
        ];

        return view('search.index', compact('annonces', 'sidebarCategories', 'sidebarParent', 'category', 'activeCategory', 'bestMatch', 'countsEtats'));
    }

    /**
     * Autocomplétion pour la barre de recherche
     */
    public function autocomplete(Request $request)
    {
        $term = $request->get('q');
        if (!$term || strlen($term) < 2) {
            return response()->json([]);
        }

        // 1. Suggestions de catégories
        $categories = Category::where('nom', 'LIKE', "%{$term}%")
            ->where('actif', true)
            ->limit(3)
            ->get(['nom', 'slug'])
            ->toBase() // Convert to base collection
            ->map(function($c) {
                return [
                    'type' => 'category',
                    'label' => "Dans la catégorie : {$c->nom}",
                    'url' => route('categories.show', $c->slug)
                ];
            });

        // 2. Suggestions de produits
        $produits = Annonce::publiees()
            ->where('titre', 'LIKE', "%{$term}%")
            ->limit(5)
            ->get(['id', 'titre', 'slug'])
            ->toBase() // Convert to base collection
            ->map(function($a) {
                return [
                    'type' => 'product',
                    'label' => $a->titre,
                    'url' => route('annonces.show', $a->slug)
                ];
            });

        return response()->json($categories->merge($produits));
    }
}
