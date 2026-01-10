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
            }, 'avisApprouves', 'options']);
        
        // Tri des produits
        $sort = request('sort', 'latest');
        switch($sort) {
            case 'price_asc':
                $annoncesQuery->orderBy('prix', 'asc');
                break;
            case 'price_desc':
                $annoncesQuery->orderBy('prix', 'desc');
                break;
            case 'latest':
            default:
                $annoncesQuery->latest();
                break;
        }
        
        $annonces = $annoncesQuery->paginate(12);

        // Charger les évaluations (avis approuvés)
        $avis = \App\Models\Avis::whereHas('annonce', function($query) use ($pagePro) {
                $query->where('vendeur_id', $pagePro->vendeur_id);
            })
            ->where('statut', 'approuve')
            ->with(['user', 'annonce'])
            ->latest()
            ->take(10)
            ->get();

        return view('page-pro.show', compact('pagePro', 'annonces', 'avis'));
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

        // Vérifier l'accès à la page pro
        if (!$vendeur->aAccesPagePro()) {
            return redirect()->route('abonnements.index')
                ->with('error', 'L\'accès à la page pro nécessite un abonnement Expert.');
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

        // Vérifier l'accès à la page pro
        if (!$vendeur->aAccesPagePro()) {
            return back()->with('error', 'L\'accès à la page pro nécessite un abonnement Expert.');
        }

        $pagePro = $vendeur->pagePro;

        if (!$pagePro) {
            $pagePro = $this->creerPagePro($vendeur);
        }

        $request->validate([
            'description' => ['nullable', 'string', 'max:2000'],
            'logo' => ['nullable', 'image', 'max:2048'], // 2 Mo
            'banniere' => ['nullable', 'image', 'max:5120'], // 5 Mo
            'telephone_contact' => ['nullable', 'string', 'max:20'],
            'email_contact' => ['nullable', 'email', 'max:255'],
            'site_web' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
        ]);

        $data = $request->only([
            'description',
            'telephone_contact',
            'email_contact',
            'site_web',
        ]);

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

        // Gestion des réseaux sociaux
        $reseauxSociaux = [];
        if ($request->facebook) {
            $reseauxSociaux['facebook'] = $request->facebook;
        }
        if ($request->instagram) {
            $reseauxSociaux['instagram'] = $request->instagram;
        }
        if ($request->twitter) {
            $reseauxSociaux['twitter'] = $request->twitter;
        }
        if ($request->linkedin) {
            $reseauxSociaux['linkedin'] = $request->linkedin;
        }
        $data['reseaux_sociaux'] = !empty($reseauxSociaux) ? $reseauxSociaux : null;

        $pagePro->update($data);

        return redirect()->route('page-pro.edit')
            ->with('success', 'Page pro mise à jour avec succès.');
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
            'slug' => $slug,
            'actif' => true,
        ]);
    }
}
