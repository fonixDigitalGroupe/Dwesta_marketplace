<?php

namespace App\Services;

use App\Models\Abonnement;
use App\Models\Vendeur;
use App\Models\VendeurAbonnement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbonnementService
{
    /**
     * Souscrire à un abonnement
     *
     * @param Vendeur $vendeur
     * @param Abonnement $abonnement
     * @param int $dureeMois Durée en mois (par défaut 1)
     * @param bool $renouvellementAutomatique
     * @return VendeurAbonnement
     * @throws \Exception
     */
    public function souscrire(Vendeur $vendeur, Abonnement $abonnement, int $dureeMois = 1, bool $renouvellementAutomatique = false): VendeurAbonnement
    {
        try {
            DB::beginTransaction();

            // Désactiver l'ancien abonnement actif s'il existe
            $this->desactiverAbonnementActif($vendeur);

            // Calculer les dates
            $dateDebut = now();
            $dateFin = $dateDebut->copy()->addMonths($dureeMois);

            // Créer le nouvel abonnement
            $vendeurAbonnement = VendeurAbonnement::create([
                'vendeur_id' => $vendeur->id,
                'abonnement_id' => $abonnement->id,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'actif' => true,
                'renouvellement_automatique' => $renouvellementAutomatique,
                'nombre_annonces_utilisees' => 0,
            ]);

            DB::commit();

            return $vendeurAbonnement;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur souscription abonnement: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Désactiver l'abonnement actif d'un vendeur
     *
     * @param Vendeur $vendeur
     * @return void
     */
    public function desactiverAbonnementActif(Vendeur $vendeur): void
    {
        VendeurAbonnement::where('vendeur_id', $vendeur->id)
            ->where('actif', true)
            ->update(['actif' => false]);
    }

    /**
     * Renouveler automatiquement un abonnement
     *
     * @param VendeurAbonnement $vendeurAbonnement
     * @return VendeurAbonnement|null
     */
    public function renouvelerAutomatiquement(VendeurAbonnement $vendeurAbonnement): ?VendeurAbonnement
    {
        if (!$vendeurAbonnement->renouvellement_automatique) {
            return null;
        }

        try {
            // Désactiver l'ancien abonnement
            $vendeurAbonnement->update(['actif' => false]);

            // Créer un nouvel abonnement avec la même configuration
            $nouveauAbonnement = VendeurAbonnement::create([
                'vendeur_id' => $vendeurAbonnement->vendeur_id,
                'abonnement_id' => $vendeurAbonnement->abonnement_id,
                'date_debut' => now(),
                'date_fin' => now()->addMonth(),
                'actif' => true,
                'renouvellement_automatique' => true,
                'nombre_annonces_utilisees' => 0,
            ]);

            return $nouveauAbonnement;
        } catch (\Exception $e) {
            Log::error('Erreur renouvellement automatique: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Vérifier et renouveler les abonnements expirés
     *
     * @return int Nombre d'abonnements renouvelés
     */
    public function verifierEtRenouvelerAbonnements(): int
    {
        $abonnementsExpires = VendeurAbonnement::where('actif', true)
            ->where('renouvellement_automatique', true)
            ->where('date_fin', '<=', now())
            ->get();

        $nombreRenouveles = 0;

        foreach ($abonnementsExpires as $abonnement) {
            if ($this->renouvelerAutomatiquement($abonnement)) {
                $nombreRenouveles++;
            }
        }

        return $nombreRenouveles;
    }

    /**
     * Désactiver les abonnements expirés
     *
     * @return int Nombre d'abonnements désactivés
     */
    public function desactiverAbonnementsExpires(): int
    {
        return VendeurAbonnement::where('actif', true)
            ->where('date_fin', '<', now())
            ->where('renouvellement_automatique', false)
            ->update(['actif' => false]);
    }

    /**
     * Calculer la commission pour un montant
     *
     * @param Vendeur $vendeur
     * @param float $montant
     * @return float Commission à prélever
     */
    public function calculerCommission(Vendeur $vendeur, float $montant): float
    {
        $abonnementActif = $vendeur->abonnementActif;
        
        if (!$abonnementActif) {
            // Utiliser l'abonnement gratuit par défaut
            $abonnement = Abonnement::where('type', Abonnement::TYPE_GRATUIT)->first();
            $tauxCommission = $abonnement ? $abonnement->commission : 10.00;
        } else {
            $tauxCommission = $abonnementActif->abonnement->commission;
        }

        return ($montant * $tauxCommission) / 100;
    }

    /**
     * Vérifier si un vendeur peut publier une annonce
     *
     * @param Vendeur $vendeur
     * @return array ['peut_publier' => bool, 'raison' => string|null]
     */
    public function peutPublierAnnonce(Vendeur $vendeur): array
    {
        // Vérifier que le vendeur est vérifié
        if (!$vendeur->estVerifie()) {
            return [
                'peut_publier' => false,
                'raison' => 'Votre compte vendeur n\'est pas encore vérifié.'
            ];
        }

        // Vérifier l'abonnement
        $abonnementActif = $vendeur->abonnementActif;
        
        if (!$abonnementActif) {
            // Utiliser l'abonnement gratuit par défaut
            $abonnement = Abonnement::where('type', Abonnement::TYPE_GRATUIT)->first();
            
            if (!$abonnement) {
                return [
                    'peut_publier' => false,
                    'raison' => 'Aucun abonnement disponible.'
                ];
            }

            // Pour l'abonnement gratuit, on vérifie le nombre d'annonces
            // TODO: Compter les annonces du vendeur
            return [
                'peut_publier' => true,
                'raison' => null
            ];
        }

        if (!$abonnementActif->peutPublierAnnonce()) {
            $abonnement = $abonnementActif->abonnement;
            
            if ($abonnement->aAnnoncesIllimitees()) {
                return [
                    'peut_publier' => false,
                    'raison' => 'Votre abonnement a expiré.'
                ];
            }

            return [
                'peut_publier' => false,
                'raison' => 'Vous avez atteint la limite d\'annonces de votre abonnement (' . $abonnement->nombre_annonces . ' annonces).'
            ];
        }

        return [
            'peut_publier' => true,
            'raison' => null
        ];
    }
}

