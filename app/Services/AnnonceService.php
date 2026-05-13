<?php

namespace App\Services;

use App\Models\Annonce;
use App\Models\AnnonceImmobilier;
use App\Models\AnnonceProduit;
use App\Models\AnnonceService as AnnonceServiceModel;
use App\Models\AnnonceVehicule;
use App\Models\Category;
use App\Models\Vendeur;
use App\Services\AnnonceOptionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnnonceService
{
    protected AnnonceOptionService $optionService;

    public function __construct(AnnonceOptionService $optionService)
    {
        $this->optionService = $optionService;
    }

    /**
     * Crée une nouvelle annonce
     *
     * @param Vendeur $vendeur
     * @param array $data
     * @param string $type Type d'annonce
     * @return Annonce
     * @throws \Exception
     */
    public function creerAnnonce(Vendeur $vendeur, array $data, string $type): Annonce
    {
        // Vérifier que le vendeur peut publier
        if (!$vendeur->peutPublierAnnonce()) {
            throw new \Exception('Vous avez atteint la limite d\'annonces de votre abonnement.');
        }

        try {
            DB::beginTransaction();

            // Générer le slug
            $slug = Annonce::generateSlug($data['titre']);

            // Créer l'annonce principale
            $annonce = Annonce::create([
                'vendeur_id' => $vendeur->id,
                'categorie_id' => $data['categorie_id'],
                'type' => $type,
                'titre' => $data['titre'],
                'slug' => $slug,
                'prix' => $data['prix'] ?? null,
                'prix_original' => $data['prix_original'] ?? null,
                'description' => $data['description'],
                'type_livraison' => $data['type_livraison'] ?? null,
                'disponibilite' => $data['disponibilite'] ?? Annonce::DISPONIBILITE_EN_STOCK,
                'statut' => $data['statut'] ?? Annonce::STATUT_BROUILLON,
                'publiee_le' => ($data['statut'] ?? Annonce::STATUT_BROUILLON) === Annonce::STATUT_PUBLIEE ? now() : null,
                'expire_le' => ($data['statut'] ?? Annonce::STATUT_BROUILLON) === Annonce::STATUT_PUBLIEE
                    ? now()->addDays(30)
                    : null,
            ]);

            // Créer les données spécifiques selon le type
            $this->creerDonneesSpecifiques($annonce, $type, $data);

            // Créer les options si fournies
            if (isset($data['options'])) {
                $this->optionService->creerOuMettreAJourOptions($annonce, $data['options']);
            }

            // Créer les variantes si fournies
            if (isset($data['variantes']) && is_array($data['variantes'])) {
                $this->enregistrerVariantes($annonce, $data['variantes']);
            }
 
            // Enregistrer les attributs dynamiques
            if (isset($data['attributes']) && is_array($data['attributes'])) {
                $this->enregistrerAttributsDynamiques($annonce, $data['attributes']);
            }

            // Incrémenter le nombre d'annonces utilisées si publiée
            if ($annonce->estPubliee()) {
                $this->incrementerAnnoncesUtilisees($vendeur);
            }

            DB::commit();

            return $annonce;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création annonce: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Met à jour une annonce
     *
     * @param Annonce $annonce
     * @param array $data
     * @return Annonce
     * @throws \Exception
     */
    public function mettreAJourAnnonce(Annonce $annonce, array $data): Annonce
    {
        try {
            DB::beginTransaction();

            // Générer un nouveau slug si le titre a changé
            $slug = $annonce->slug;
            if (isset($data['titre']) && $data['titre'] !== $annonce->titre) {
                $slug = Annonce::generateSlug($data['titre'], $annonce->id);
            }

            $newStatut = $data['statut'] ?? $annonce->statut;
            $publiee_le = $annonce->publiee_le;
            if ($newStatut === Annonce::STATUT_PUBLIEE && !$publiee_le) {
                $publiee_le = now();
            }

            // Mettre à jour l'annonce principale
            $annonce->update([
                'categorie_id' => $data['categorie_id'] ?? $annonce->categorie_id,
                'titre'        => $data['titre'] ?? $annonce->titre,
                'slug'         => $slug,
                'prix'         => $data['prix'] ?? $annonce->prix,
                'prix_original' => $data['prix_original'] ?? $annonce->prix_original,
                'description'  => $data['description'] ?? $annonce->description,
                'type_livraison' => $data['type_livraison'] ?? $annonce->type_livraison,
                'disponibilite'  => $data['disponibilite'] ?? $annonce->disponibilite,
                'statut'         => $newStatut,
                'publiee_le'     => $publiee_le,
            ]);

            // Mettre à jour les données spécifiques
            $this->mettreAJourDonneesSpecifiques($annonce, $data);

            // Mettre à jour les options si fournies
            if (isset($data['options'])) {
                $this->optionService->creerOuMettreAJourOptions($annonce, $data['options']);
            }

            // Mettre à jour les variantes si fournies
            if (isset($data['variantes']) && is_array($data['variantes'])) {
                $this->enregistrerVariantes($annonce, $data['variantes']);
            }

            // Mettre à jour les attributs dynamiques
            if (isset($data['attributes']) && is_array($data['attributes'])) {
                $this->enregistrerAttributsDynamiques($annonce, $data['attributes']);
            }

            DB::commit();

            return $annonce->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur mise à jour annonce: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Publie une annonce (passe de brouillon à publiée)
     *
     * @param Annonce $annonce
     * @return Annonce
     * @throws \Exception
     */
    public function publierAnnonce(Annonce $annonce): Annonce
    {
        $vendeur = $annonce->vendeur;

        // Vérifier que le vendeur peut publier
        if (!$vendeur->peutPublierAnnonce()) {
            throw new \Exception('Vous avez atteint la limite d\'annonces de votre abonnement.');
        }

        // Vérifier que l'annonce a au moins une photo
        if ($annonce->photos()->count() === 0) {
            throw new \Exception('Vous devez ajouter au moins une photo avant de publier.');
        }

        try {
            DB::beginTransaction();

            $annonce->update([
                'statut' => Annonce::STATUT_PUBLIEE,
                'publiee_le' => now(),
                'expire_le' => now()->addDays(30),
            ]);

            // Incrémenter le nombre d'annonces utilisées
            $this->incrementerAnnoncesUtilisees($vendeur);

            DB::commit();

            return $annonce->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Crée les données spécifiques selon le type d'annonce
     */
    private function creerDonneesSpecifiques(Annonce $annonce, string $type, array $data): void
    {
        switch ($type) {
            case Annonce::TYPE_PRODUIT:
                AnnonceProduit::create([
                    'annonce_id' => $annonce->id,
                    'prix_moyen_marche' => $data['prix_moyen_marche'] ?? null,
                    'badges' => $data['badges'] ?? null,
                    'marque' => $data['marque'] ?? null,
                    'modele' => $data['modele'] ?? null,
                    'etat' => $data['etat'] ?? null,
                    'quantite' => $data['quantite'] ?? 1,
                ]);
                break;

            case Annonce::TYPE_SERVICE:
                AnnonceServiceModel::create([
                    'annonce_id' => $annonce->id,
                    'type_tarification' => $data['type_tarification'] ?? AnnonceServiceModel::TARIF_FIXE,
                    'tarif_horaire' => $data['tarif_horaire'] ?? null,
                    'duree_estimee' => $data['duree_estimee'] ?? null,
                    'deplacement_inclus' => $data['deplacement_inclus'] ?? false,
                    'zone_intervention' => $data['zone_intervention'] ?? null,
                ]);
                break;

            case Annonce::TYPE_IMMOBILIER:
                AnnonceImmobilier::create([
                    'annonce_id' => $annonce->id,
                    'type_transaction' => $data['type_transaction'] ?? 'vente',
                    'prix_vente' => $data['prix_vente'] ?? null,
                    'loyer_mensuel' => $data['loyer_mensuel'] ?? null,
                    'surface' => $data['surface'] ?? null,
                    'pieces' => $data['pieces'] ?? null,
                    'chambres' => $data['chambres'] ?? null,
                    'equipements' => $data['equipements'] ?? null,
                ]);
                break;

            case Annonce::TYPE_VEHICULE:
                AnnonceVehicule::create([
                    'annonce_id' => $annonce->id,
                    'marque' => $data['marque'],
                    'modele' => $data['modele'],
                    'annee' => $data['annee'] ?? null,
                    'kilometrage' => $data['kilometrage'] ?? null,
                    'carburant' => $data['carburant'] ?? null,
                    'boite_vitesse' => $data['boite_vitesse'] ?? null,
                    'etat' => $data['etat'] ?? null,
                    'couleur' => $data['couleur'] ?? null,
                    'portes' => $data['portes'] ?? null,
                    'places' => $data['places'] ?? null,
                ]);
                break;
        }
    }

    /**
     * Met à jour les données spécifiques selon le type d'annonce
     */
    private function mettreAJourDonneesSpecifiques(Annonce $annonce, array $data): void
    {
        switch ($annonce->type) {
            case Annonce::TYPE_PRODUIT:
                if ($annonce->produit) {
                    $annonce->produit->update([
                        'prix_moyen_marche' => $data['prix_moyen_marche'] ?? $annonce->produit->prix_moyen_marche,
                        'badges' => $data['badges'] ?? $annonce->produit->badges,
                        'marque' => $data['marque'] ?? $annonce->produit->marque,
                        'modele' => $data['modele'] ?? $annonce->produit->modele,
                        'etat' => $data['etat'] ?? $annonce->produit->etat,
                        'quantite' => $data['quantite'] ?? $annonce->produit->quantite,
                    ]);
                }
                break;

            case Annonce::TYPE_SERVICE:
                if ($annonce->service) {
                    $annonce->service->update([
                        'type_tarification' => $data['type_tarification'] ?? $annonce->service->type_tarification,
                        'tarif_horaire' => $data['tarif_horaire'] ?? $annonce->service->tarif_horaire,
                        'duree_estimee' => $data['duree_estimee'] ?? $annonce->service->duree_estimee,
                        'deplacement_inclus' => $data['deplacement_inclus'] ?? $annonce->service->deplacement_inclus,
                        'zone_intervention' => $data['zone_intervention'] ?? $annonce->service->zone_intervention,
                    ]);
                }
                break;

            case Annonce::TYPE_IMMOBILIER:
                if ($annonce->immobilier) {
                    $annonce->immobilier->update([
                        'type_transaction' => $data['type_transaction'] ?? $annonce->immobilier->type_transaction,
                        'prix_vente' => $data['prix_vente'] ?? $annonce->immobilier->prix_vente,
                        'loyer_mensuel' => $data['loyer_mensuel'] ?? $annonce->immobilier->loyer_mensuel,
                        'surface' => $data['surface'] ?? $annonce->immobilier->surface,
                        'pieces' => $data['pieces'] ?? $annonce->immobilier->pieces,
                        'chambres' => $data['chambres'] ?? $annonce->immobilier->chambres,
                        'equipements' => $data['equipements'] ?? $annonce->immobilier->equipements,
                    ]);
                }
                break;

            case Annonce::TYPE_VEHICULE:
                if ($annonce->vehicule) {
                    $annonce->vehicule->update([
                        'marque' => $data['marque'] ?? $annonce->vehicule->marque,
                        'modele' => $data['modele'] ?? $annonce->vehicule->modele,
                        'annee' => $data['annee'] ?? $annonce->vehicule->annee,
                        'kilometrage' => $data['kilometrage'] ?? $annonce->vehicule->kilometrage,
                        'carburant' => $data['carburant'] ?? $annonce->vehicule->carburant,
                        'boite_vitesse' => $data['boite_vitesse'] ?? $annonce->vehicule->boite_vitesse,
                        'etat' => $data['etat'] ?? $annonce->vehicule->etat,
                        'couleur' => $data['couleur'] ?? $annonce->vehicule->couleur,
                        'portes' => $data['portes'] ?? $annonce->vehicule->portes,
                        'places' => $data['places'] ?? $annonce->vehicule->places,
                    ]);
                }
                break;
        }
    }

    /**
     * Enregistre les variantes d'une annonce
     */
    private function enregistrerVariantes(Annonce $annonce, array $variantes): void
    {
        // Supprimer les anciennes variantes
        $annonce->variantes()->delete();

        foreach ($variantes as $variante) {
            if (!empty($variante['valeur'])) {
                $annonce->variantes()->create([
                    'type' => $variante['type'] ?? 'taille',
                    'valeur' => $variante['valeur'],
                    'stock' => $variante['stock'] ?? 0,
                    'prix_supplementaire' => $variante['prix_supplementaire'] ?? 0,
                ]);
            }
        }
    }


    private function enregistrerAttributsDynamiques(Annonce $annonce, array $attributes): void
    {
        // Supprimer les anciens attributs
        $annonce->filteredAttributes()->delete();

        foreach ($attributes as $filterId => $value) {
            if ($value !== null && $value !== '' && (!is_array($value) || count($value) > 0)) {
                $finalValue = is_array($value) ? implode(', ', $value) : $value;
                $annonce->filteredAttributes()->create([
                    'category_filter_id' => $filterId,
                    'value' => $finalValue,
                ]);
            }
        }
    }

    /**
     * Incrémente le nombre d'annonces utilisées pour le vendeur
     */
    private function incrementerAnnoncesUtilisees(Vendeur $vendeur): void
    {
        $abonnementActif = $vendeur->abonnementActif;

        if ($abonnementActif) {
            $abonnementActif->increment('nombre_annonces_utilisees');
        }
    }
}

