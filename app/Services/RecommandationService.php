<?php

namespace App\Services;

use App\Models\Annonce;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecommandationService
{
    /**
     * Obtenir les produits similaires (même catégorie, prix proche)
     *
     * @param Annonce $annonce
     * @param int $limit Nombre de produits à retourner
     * @return Collection
     */
    public function getProduitsSimilaires(Annonce $annonce, int $limit = 8): Collection
    {
        // Produits de la même catégorie
        $query = Annonce::publiees()
            ->where('id', '!=', $annonce->id)
            ->where('categorie_id', $annonce->categorie_id)
            ->where('type', $annonce->type)
            ->with(['photos', 'category', 'vendeur.user', 'options']);

        // Si l'annonce a un prix, chercher des produits avec un prix proche (±30%)
        if ($annonce->prix) {
            $prixMin = $annonce->prix * 0.7;
            $prixMax = $annonce->prix * 1.3;
            
            $query->whereBetween('prix', [$prixMin, $prixMax]);
        }

        // Prioriser les annonces avec option "À la Une"
        // Utiliser une approche compatible SQLite et MySQL
        $now = now()->toDateTimeString();
        $query->orderByRaw("CASE WHEN EXISTS (
            SELECT 1 FROM annonce_options 
            WHERE annonce_options.annonce_id = annonces.id 
            AND annonce_options.a_la_une = 1
            AND (annonce_options.a_la_une_expire_le IS NULL OR annonce_options.a_la_une_expire_le > ?)
        ) THEN 0 ELSE 1 END", [$now])
        ->orderBy('vues', 'desc')
        ->orderBy('publiee_le', 'desc');

        return $query->limit($limit)->get();
    }

    /**
     * Obtenir les produits "Achetez souvent ensemble"
     * Pour l'instant, on retourne des produits de la même catégorie avec de bonnes notes
     * TODO: Implémenter un vrai algorithme basé sur les commandes (Phase 7)
     *
     * @param Annonce $annonce
     * @param int $limit Nombre de produits à retourner
     * @return Collection
     */
    public function getAchetezSouventEnsemble(Annonce $annonce, int $limit = 6): Collection
    {
        // Pour l'instant, on retourne des produits de la même catégorie avec de bonnes notes
        // En Phase 7, on pourra analyser les commandes pour trouver les produits achetés ensemble
        
        $query = Annonce::publiees()
            ->where('id', '!=', $annonce->id)
            ->where('categorie_id', $annonce->categorie_id)
            ->with(['photos', 'category', 'vendeur.user', 'options', 'avisApprouves'])
            ->has('avisApprouves') // Seulement les produits avec des avis
            ->withCount(['avisApprouves as note_moyenne' => function ($query) {
                $query->selectRaw('AVG(note)')
                    ->where('statut', 'approuve');
            }])
            ->orderBy('note_moyenne', 'desc')
            ->orderBy('vues', 'desc');

        return $query->limit($limit)->get();
    }

    /**
     * Obtenir les produits sponsorisés
     * Les produits sponsorisés sont ceux avec l'option "À la Une" active
     *
     * @param Annonce $annonce Annonce actuelle (pour exclure)
     * @param int $limit Nombre de produits à retourner
     * @return Collection
     */
    public function getProduitsSponsorises(Annonce $annonce, int $limit = 4): Collection
    {
        return Annonce::publiees()
            ->where('id', '!=', $annonce->id)
            ->whereHas('options', function ($query) {
                $query->where('a_la_une', true)
                    ->where(function ($q) {
                        $q->whereNull('a_la_une_expire_le')
                            ->orWhere('a_la_une_expire_le', '>', now());
                    });
            })
            ->with(['photos', 'category', 'vendeur.user', 'options'])
            ->orderBy('vues', 'desc')
            ->orderBy('publiee_le', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtenir les meilleures offres des vendeurs pros
     * (Similaires, sponsorisés ou vendeurs professionnels)
     */
    public function getMeilleuresOffresPro(Annonce $annonce, int $limit = 8): Collection
    {
        return Annonce::publiees()
            ->where('id', '!=', $annonce->id)
            ->where('categorie_id', $annonce->categorie_id)
            ->where(function ($query) {
                // Sponsorisé (À la Une)
                $query->whereHas('options', function ($q) {
                    $q->where('a_la_une', true)
                        ->where(function ($q2) {
                            $q2->whereNull('a_la_une_expire_le')
                                ->orWhere('a_la_une_expire_le', '>', now());
                        });
                })
                // OU Vendeur Pro
                ->orWhereHas('vendeur', function ($q) {
                    $q->where('type', 'professionnel');
                });
            })
            ->with(['photos', 'category', 'vendeur.user', 'vendeur.professionnel', 'options'])
            ->orderByRaw("CASE WHEN EXISTS (
                SELECT 1 FROM annonce_options 
                WHERE annonce_options.annonce_id = annonces.id 
                AND annonce_options.a_la_une = 1
                AND (annonce_options.a_la_une_expire_le IS NULL OR annonce_options.a_la_une_expire_le > ?)
            ) THEN 0 ELSE 1 END", [now()->toDateTimeString()])
            ->orderBy('vues', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtenir les produits aussi vus par les clients
     */
    public function getProduitsAussiVus(Annonce $annonce, int $limit = 8): Collection
    {
        return Annonce::publiees()
            ->where('id', '!=', $annonce->id)
            ->where('categorie_id', $annonce->categorie_id)
            ->with(['photos', 'category', 'vendeur.user', 'options'])
            ->orderBy('vues', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtenir les produits aussi aimés par les clients (basé sur les favoris)
     */
    public function getProduitsAussiAimes(Annonce $annonce, int $limit = 8): Collection
    {
        return Annonce::publiees()
            ->where('id', '!=', $annonce->id)
            ->where('categorie_id', $annonce->categorie_id)
            ->with(['photos', 'category', 'vendeur.user', 'options'])
            ->withCount('favoritedBy')
            ->orderBy('favorited_by_count', 'desc')
            ->orderBy('vues', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtenir toutes les recommandations pour une annonce
     *
     * @param Annonce $annonce
     * @return array
     */
    public function getAllRecommandations(Annonce $annonce): array
    {
        return [
            'similaires' => $this->getProduitsSimilaires($annonce, 8),
            'achetez_ensemble' => $this->getAchetezSouventEnsemble($annonce, 6),
            'sponsorises' => $this->getProduitsSponsorises($annonce, 4),
            'meilleures_offres_pro' => $this->getMeilleuresOffresPro($annonce, 8),
            'aussi_vus' => $this->getProduitsAussiVus($annonce, 8),
            'aussi_aimes' => $this->getProduitsAussiAimes($annonce, 8),
        ];
    }
}

