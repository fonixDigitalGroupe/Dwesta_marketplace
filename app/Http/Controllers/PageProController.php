<?php

namespace App\Http\Controllers;

use App\Models\PagePro;
use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageProController extends Controller
{
    public function __construct()
    {
        // Le middleware 'auth' est déjà appliqué dans les routes
        // La méthode 'show' est accessible sans authentification
    }

    /**
     * Affiche la page pro publique
     */
    public function show(string $slug)
    {
        $pagePro = PagePro::where('slug', $slug)
            ->where('actif', true)
            ->with(['vendeur.user', 'vendeur.professionnel', 'vendeur.particulier'])
            ->firstOrFail();

        // Incrémenter le nombre de vues
        $pagePro->incrementerVues();

        // Charger les annonces publiées du vendeur
        $annoncesQuery = $pagePro->vendeur->annonces()
            ->where('statut', 'publiee')
            ->with(['categorie', 'medias' => function($query) {
                $query->where('type', 'photo')->orderBy('ordre');
            }, 'avisApprouves', 'options', 'produit', 'vehicule']);

        // Recherche intelligente et tolérante aux fautes (SOUNDS LIKE + Keywords)
        if (request()->filled('q')) {
            $search = trim(request('q'));
            $annoncesQuery->where(function($query) use ($search) {
                // 1. Recherche exacte et large
                $query->where('titre', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                
                // 2. Décomposition en mots-clés pour gérer l'ordre et les fautes
                $keywords = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);
                
                foreach ($keywords as $word) {
                    if (strlen($word) >= 3) {
                        $query->orWhere('titre', 'like', "%{$word}%")
                              ->orWhere('description', 'like', "%{$word}%")
                              // SOUNDS LIKE aide pour les fautes de frappe phonétiques
                              ->orWhereRaw("titre SOUNDS LIKE ?", [$word]);
                    }
                }
            });
        }

        // Filtre par catégorie (sidebar)
        $active_category = null;
        $active_category_obj = null;
        if (request()->filled('category')) {
            $categoryId = (int) request('category');
            $active_category = $categoryId;
            $active_category_obj = \App\Models\Category::with('parent.parent')->find($categoryId);
            // Inclure aussi les sous-catégories enfants
            $childIds = \App\Models\Category::where('parent_id', $categoryId)->pluck('id')->toArray();
            $allIds = array_merge([$categoryId], $childIds);
            $annoncesQuery->whereIn('categorie_id', $allIds);
        }

        // Filtre par prix
        if (request()->filled('price_min')) {
            $annoncesQuery->where('prix', '>=', (float) request('price_min'));
        }
        if (request()->filled('price_max')) {
            $annoncesQuery->where('prix', '<=', (float) request('price_max'));
        }

        // Filtre par note minimale (avis client)
        if (request()->filled('rating')) {
            $minNote = (int) request('rating');
            $annoncesQuery->whereHas('avisApprouves', function($q) use ($minNote) {
                $q->where('note', '>=', $minNote);
            });
        }

        // Filtre par état du produit
        if (request()->filled('etat')) {
            $etatMap = [
                'neuf'          => 'neuf',
                'reconditionne' => 'reconditionné',
                'occasion'      => 'occasion',
            ];
            $etatVal = $etatMap[request('etat')] ?? request('etat');
            
            $annoncesQuery->where(function($q) use ($etatVal) {
                $q->whereHas('produit', function($sq) use ($etatVal) {
                    $sq->where('etat', $etatVal);
                })->orWhereHas('vehicule', function($sq) use ($etatVal) {
                    $sq->where('etat', $etatVal);
                });
            });
        }

        // Filtre par critères dynamiques
        if (request()->filled('filters')) {
            $reqFilters = request('filters');
            if (is_array($reqFilters)) {
                foreach ($reqFilters as $filterId => $value) {
                    if (!empty($value)) {
                        $annoncesQuery->whereHas('filteredAttributes', function($q) use ($filterId, $value) {
                            $q->where('category_filter_id', $filterId)
                              ->where('value', $value);
                        });
                    }
                }
            }
        }

        // Tri des produits
        $sort = request('sort', 'latest');
        switch($sort) {
            case 'price_asc':
                $annoncesQuery->orderBy('prix', 'asc');
                break;
            case 'price_desc':
                $annoncesQuery->orderBy('prix', 'desc');
                break;
            case 'newest':
                $annoncesQuery->latest();
                break;
            case 'latest':
            default:
                $annoncesQuery->latest();
                break;
        }

        $annonces = $annoncesQuery->paginate(20)->appends(request()->query());

        // Charger les évaluations (avis approuvés)
        $avis = \App\Models\Avis::whereHas('annonce', function($query) use ($pagePro) {
                $query->where('vendeur_id', $pagePro->vendeur_id);
            })
            ->where('statut', 'approuve')
            ->with(['user', 'annonce'])
            ->latest()
            ->take(10)
            ->get();

        // Charger les catégories spécifiques (sous-catégories uniquement) des produits
        $vendeur_categories = \App\Models\Category::whereHas('annonces', function($query) use ($pagePro) {
            $query->where('vendeur_id', $pagePro->vendeur_id)
                  ->where('statut', 'publiee');
        })
        ->whereNotNull('parent_id')
        ->with(['parent.parent']) // Pour détecter le niveau 3
        ->withCount(['annonces' => function($query) use ($pagePro) {
            $query->where('vendeur_id', $pagePro->vendeur_id)
                  ->where('statut', 'publiee');
        }])->get();

        // Calculer la moyenne des avis de la boutique
        $boutique_rating = \App\Models\Avis::whereHas('annonce', function($q) use ($pagePro) {
                $q->where('vendeur_id', $pagePro->vendeur_id);
            })
            ->where('statut', 'approuve')
            ->avg('note') ?: 0;
        
        // Calculer le nombre total de ventes (commandes payées ou livrées)
        $boutique_sales = \App\Models\Order::where('vendeur_id', $pagePro->vendeur_id)
            ->whereNotIn('statut', [\App\Models\Order::STATUT_EN_ATTENTE, \App\Models\Order::STATUT_ANNULE])
            ->count();

        // Statistiques dynamiques des avis par note (compteurs cumulatifs)
        $avisParNote = \App\Models\Avis::whereHas('annonce', function($q) use ($pagePro) {
                $q->where('vendeur_id', $pagePro->vendeur_id);
            })
            ->where('statut', 'approuve')
            ->selectRaw('note, COUNT(*) as total')
            ->groupBy('note')
            ->pluck('total', 'note')
            ->toArray();

        // Compteurs cumulatifs : "4 étoiles et plus" = note >= 4, etc.
        $avis_stats = [
            4 => collect($avisParNote)->filter(fn($v, $k) => $k >= 4)->sum(),
            3 => collect($avisParNote)->filter(fn($v, $k) => $k >= 3)->sum(),
            2 => collect($avisParNote)->filter(fn($v, $k) => $k >= 2)->sum(),
            1 => collect($avisParNote)->filter(fn($v, $k) => $k >= 1)->sum(),
        ];

        // Charger les filtres de la catégorie si c'est un niveau 3
        $category_filters = collect();
        if ($active_category_obj) {
            $isLevel3 = $active_category_obj->parent && $active_category_obj->parent->parent_id !== null;
            if ($isLevel3) {
                $category_filters = \App\Models\CategoryFilter::where('category_id', $active_category)
                    ->where('is_filterable', true)
                    ->orderBy('ordre')
                    ->get();
            }
        }

        return view('page-pro.show', compact('pagePro', 'annonces', 'avis', 'vendeur_categories', 'active_category', 'active_category_obj', 'avis_stats', 'category_filters', 'boutique_rating', 'boutique_sales'));
    }

    /**
     * Affiche le formulaire d'édition de la page pro
     */
    public function edit()
    {
        $user = Auth::user();

        if (!$user->estVendeur()) {
            return redirect()->route('vendeur.create')
                ->with('error', 'Vous devez être vendeur pour accéder à cette page.');
        }

        $vendeur = $user->vendeur;

        // Vérifier l'accès à la personnalisation de la boutique
        if (!$vendeur->peutPersonnaliserBoutique()) {
            return redirect()->route('abonnements.index')
                ->with('error', 'L\'abonnement Expert est requis pour personnaliser votre boutique.');
        }

        $pagePro = $vendeur->pagePro;

        // Si la page pro n'existe pas, la créer
        if (!$pagePro) {
            $pagePro = $this->creerPagePro($vendeur);
        }

        return view('page-pro.edit', compact('pagePro', 'vendeur'));
    }

    /**
     * Met à jour la page pro
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user->estVendeur()) {
            return back()->with('error', 'Vous devez être vendeur.');
        }

        $vendeur = $user->vendeur;

        // Vérification des erreurs brutes PHP (on ignore l'erreur 4 qui signifie "aucun fichier sélectionné")
        if (isset($_FILES['banniere']) && $_FILES['banniere']['error'] !== UPLOAD_ERR_OK && $_FILES['banniere']['error'] !== UPLOAD_ERR_NO_FILE) {
            $errorCodes = [
                1 => 'Le fichier dépasse upload_max_filesize dans php.ini',
                2 => 'Le fichier dépasse MAX_FILE_SIZE dans le formulaire',
                3 => 'Le fichier n\'a été que partiellement téléchargé',
                6 => 'Dossier temporaire manquant',
                7 => 'Échec de l\'écriture du fichier sur le disque',
                8 => 'Une extension PHP a arrêté le téléchargement'
            ];
            $err = $_FILES['banniere']['error'];
            $msg = $errorCodes[$err] ?? 'Erreur inconnue (' . $err . ')';
            return back()->with('error', 'PHP brute error (Bannière): ' . $msg);
        }

        if (isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_OK && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
             $err = $_FILES['logo']['error'];
             return back()->with('error', 'PHP brute error (Logo): Code ' . $err);
        }

        $pagePro = $vendeur->pagePro;

        if (!$pagePro) {
            $pagePro = $this->creerPagePro($vendeur);
        }

        $request->validate([
            'nom_boutique' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'logo' => ['nullable', 'image', 'max:5120'], 
            'banniere' => ['nullable', 'image', 'max:10240'], 
            'telephone_contact' => ['nullable', 'string', 'max:50'],
            'email_contact' => ['nullable', 'email', 'max:255'],
            'site_web' => ['nullable', 'string', 'max:255'],
            'couleur_primaire' => ['nullable', 'string', 'max:20'],
        ]);

        $data = $request->only([
            'nom_boutique',
            'description',
            'telephone_contact',
            'email_contact',
            'site_web',
            'couleur_primaire',
        ]);

        // Préparation des réseaux sociaux (plus simple)
        $reseauxSociaux = [
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
        ];
        $data['reseaux_sociaux'] = $reseauxSociaux;

        // Gestion du logo
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo
            if ($pagePro->logo) {
                Storage::disk('public')->delete($pagePro->logo);
            }

            $logoPath = $request->file('logo')->store('page-pro/logos', 'public');
            $data['logo'] = $logoPath;
        }

        // Gestion de la bannière
        if ($request->hasFile('banniere')) {
            // Supprimer l'ancienne bannière
            if ($pagePro->banniere) {
                Storage::disk('public')->delete($pagePro->banniere);
            }

            $bannierePath = $request->file('banniere')->store('page-pro/bannieres', 'public');
            $data['banniere'] = $bannierePath;
        }

        $pagePro->update($data);

        return back()->with('success', 'Votre boutique a été mise à jour avec succès !');
    }

    /**
     * Crée une page pro pour un vendeur
     */
    protected function creerPagePro(Vendeur $vendeur): PagePro
    {
        // Générer un slug à partir du nom du vendeur
        $nomVendeur = $vendeur->user->prenom . ' ' . ($vendeur->user->nom ?? '');
        
        if ($vendeur->estProfessionnel() && $vendeur->professionnel) {
            $nomVendeur = $vendeur->professionnel->nom_entreprise;
        }

        $slug = PagePro::generateSlug($nomVendeur);

        return PagePro::create([
            'vendeur_id' => $vendeur->id,
            'nom_boutique' => $nomVendeur,
            'slug' => $slug,
            'actif' => true,
        ]);
    }
}
