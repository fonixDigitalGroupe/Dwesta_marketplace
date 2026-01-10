<?php

namespace App\Services;

use App\Models\Annonce;
use App\Models\AnnonceOption;
use Carbon\Carbon;

class AnnonceOptionService
{
    /**
     * Prix des options (en crédits ou FCFA)
     */
    private const PRIX_A_LA_UNE = 5000; // 5000 FCFA ou crédits
    private const PRIX_URGENT = 3000; // 3000 FCFA ou crédits
    private const PRIX_VIDEO = 10000; // 10000 FCFA ou crédits
    private const PRIX_REPUBLICATION = 2000; // 2000 FCFA ou crédits
    private const PRIX_FRAIS_INSERTION = 1000; // 1000 FCFA ou crédits par annonce

    /**
     * Durée des options (en jours)
     */
    private const DUREE_A_LA_UNE = 7; // 7 jours
    private const DUREE_URGENT = 7; // 7 jours
    private const DUREE_VIDEO = 30; // 30 jours

    /**
     * Crée ou met à jour les options d'une annonce
     *
     * @param Annonce $annonce
     * @param array $options Options sélectionnées
     * @return AnnonceOption
     */
    public function creerOuMettreAJourOptions(Annonce $annonce, array $options): AnnonceOption
    {
        $option = AnnonceOption::firstOrNew(['annonce_id' => $annonce->id]);

        // Calculer les frais d'insertion
        $fraisInsertion = $this->calculerFraisInsertion($annonce);

        // Mettre à jour les options
        $option->a_la_une = $options['a_la_une'] ?? false;
        $option->urgent = $options['urgent'] ?? false;
        $option->video = $options['video'] ?? false;
        $option->republication_auto = $options['republication_auto'] ?? false;
        $option->frais_insertion = $fraisInsertion;

        // Définir les dates d'expiration
        if ($option->a_la_une) {
            $option->a_la_une_expire_le = Carbon::now()->addDays(self::DUREE_A_LA_UNE);
        }

        if ($option->urgent) {
            $option->urgent_expire_le = Carbon::now()->addDays(self::DUREE_URGENT);
        }

        if ($option->video) {
            $option->video_expire_le = Carbon::now()->addDays(self::DUREE_VIDEO);
        }

        $option->save();

        return $option;
    }

    /**
     * Calcule le coût total des options sélectionnées
     *
     * @param array $options
     * @param Annonce|null $annonce
     * @return float
     */
    public function calculerCoutTotal(array $options, ?Annonce $annonce = null): float
    {
        $cout = 0;

        if ($options['a_la_une'] ?? false) {
            $cout += self::PRIX_A_LA_UNE;
        }

        if ($options['urgent'] ?? false) {
            $cout += self::PRIX_URGENT;
        }

        if ($options['video'] ?? false) {
            $cout += self::PRIX_VIDEO;
        }

        if ($options['republication_auto'] ?? false) {
            $cout += self::PRIX_REPUBLICATION;
        }

        // Frais d'insertion
        if ($annonce) {
            $cout += $this->calculerFraisInsertion($annonce);
        } else {
            $cout += self::PRIX_FRAIS_INSERTION;
        }

        return $cout;
    }

    /**
     * Calcule les frais d'insertion selon l'abonnement
     *
     * @param Annonce $annonce
     * @return float
     */
    public function calculerFraisInsertion(Annonce $annonce): float
    {
        $vendeur = $annonce->vendeur;
        $abonnementActif = $vendeur->abonnementActif;

        // Si l'abonnement inclut des annonces gratuites, vérifier le nombre utilisé
        if ($abonnementActif && $abonnementActif->abonnement->nombre_annonces > 0) {
            // TODO: Vérifier le nombre d'annonces déjà publiées ce mois
            // Pour l'instant, on considère que les frais sont toujours appliqués
        }

        return self::PRIX_FRAIS_INSERTION;
    }

    /**
     * Achete une option pour une annonce
     * TODO: Intégrer avec le système de crédits (Phase 10)
     *
     * @param Annonce $annonce
     * @param string $typeOption Type d'option : 'a_la_une', 'urgent', 'video', 'republication_auto'
     * @return bool
     * @throws \Exception
     */
    public function acheterOption(Annonce $annonce, string $typeOption): bool
    {
        $prix = $this->getPrixOption($typeOption);

        // TODO: Vérifier le solde de crédits de l'utilisateur
        // TODO: Débiter les crédits
        // Pour l'instant, on suppose que le paiement a été effectué

        $option = AnnonceOption::firstOrCreate(['annonce_id' => $annonce->id]);

        switch ($typeOption) {
            case 'a_la_une':
                $option->a_la_une = true;
                $option->a_la_une_expire_le = Carbon::now()->addDays(self::DUREE_A_LA_UNE);
                break;
            case 'urgent':
                $option->urgent = true;
                $option->urgent_expire_le = Carbon::now()->addDays(self::DUREE_URGENT);
                break;
            case 'video':
                $option->video = true;
                $option->video_expire_le = Carbon::now()->addDays(self::DUREE_VIDEO);
                break;
            case 'republication_auto':
                $option->republication_auto = true;
                break;
            default:
                throw new \Exception("Type d'option invalide : {$typeOption}");
        }

        $option->save();

        return true;
    }

    /**
     * Obtient le prix d'une option
     *
     * @param string $typeOption
     * @return float
     */
    public function getPrixOption(string $typeOption): float
    {
        return match ($typeOption) {
            'a_la_une' => self::PRIX_A_LA_UNE,
            'urgent' => self::PRIX_URGENT,
            'video' => self::PRIX_VIDEO,
            'republication_auto' => self::PRIX_REPUBLICATION,
            'frais_insertion' => self::PRIX_FRAIS_INSERTION,
            default => 0,
        };
    }

    /**
     * Vérifie et désactive les options expirées
     *
     * @param AnnonceOption $option
     * @return void
     */
    public function verifierExpiration(AnnonceOption $option): void
    {
        $now = Carbon::now();

        if ($option->a_la_une_expire_le && $option->a_la_une_expire_le->isPast()) {
            $option->a_la_une = false;
        }

        if ($option->urgent_expire_le && $option->urgent_expire_le->isPast()) {
            $option->urgent = false;
        }

        if ($option->video_expire_le && $option->video_expire_le->isPast()) {
            $option->video = false;
        }

        $option->save();
    }

    /**
     * Républie automatiquement une annonce expirée
     *
     * @param Annonce $annonce
     * @return bool
     */
    public function republierAnnonce(Annonce $annonce): bool
    {
        $option = $annonce->options;

        if (!$option || !$option->republication_auto) {
            return false;
        }

        // Vérifier que l'annonce est expirée
        if (!$annonce->estExpiree()) {
            return false;
        }

        // TODO: Vérifier le solde de crédits pour les frais d'insertion
        // TODO: Débiter les crédits

        // Républier l'annonce
        $annonce->update([
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
            'expire_le' => now()->addDays(30), // 30 jours par défaut
        ]);

        return true;
    }

    /**
     * Obtient toutes les options disponibles avec leurs prix
     *
     * @return array
     */
    public function getOptionsDisponibles(): array
    {
        return [
            'a_la_une' => [
                'nom' => 'À la Une',
                'prix' => self::PRIX_A_LA_UNE,
                'duree' => self::DUREE_A_LA_UNE,
                'description' => 'Votre annonce apparaîtra en haut des résultats de recherche pendant 7 jours',
            ],
            'urgent' => [
                'nom' => 'Urgent',
                'prix' => self::PRIX_URGENT,
                'duree' => self::DUREE_URGENT,
                'description' => 'Badge "Urgent" visible sur votre annonce pendant 7 jours',
            ],
            'video' => [
                'nom' => 'Vidéo',
                'prix' => self::PRIX_VIDEO,
                'duree' => self::DUREE_VIDEO,
                'description' => 'Possibilité d\'ajouter une vidéo à votre annonce (30 jours)',
            ],
            'republication_auto' => [
                'nom' => 'Republication automatique',
                'prix' => self::PRIX_REPUBLICATION,
                'duree' => null,
                'description' => 'Votre annonce sera automatiquement republiée à l\'expiration',
            ],
        ];
    }
}

