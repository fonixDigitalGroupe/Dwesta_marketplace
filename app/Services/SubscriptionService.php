<?php

namespace App\Services;

use App\Models\Vendeur;
use App\Models\VendeurAbonnement;

class SubscriptionService
{
    /**
     * Obtenir le taux de commission du vendeur selon son abonnement
     */
    public function getCommissionRate(Vendeur $vendeur): float
    {
        $abonnementActuel = $vendeur->abonnementActuel;
        
        if (!$abonnementActuel) {
            // Par défaut, utiliser la commission de l'abonnement gratuit (3%)
            return 3.00;
        }

        return $abonnementActuel->commission;
    }

    /**
     * Vérifier si le vendeur peut publier une nouvelle annonce
     */
    public function canPublishAnnonce(Vendeur $vendeur): bool
    {
        // Vérifier le statut de vérification
        if ($vendeur->statut_verification === 'rejeté') {
            return false;
        }

        $abonnementActif = $vendeur->abonnementActif;

        if (!$abonnementActif) {
            // Si pas d'abonnement actif, vérifier les limites de l'abonnement gratuit
            $abonnementGratuit = \App\Models\Abonnement::where('type', \App\Models\Abonnement::TYPE_GRATUIT)->first();
            
            if (!$abonnementGratuit) {
                return false;
            }

            // Compter les annonces publiées du vendeur
            $nombreAnnonces = $vendeur->annonces()->whereIn('statut', ['publiee', 'en_attente'])->count();
            
            return $nombreAnnonces < $abonnementGratuit->nombre_annonces;
        }

        return $abonnementActif->peutPublierAnnonce();
    }

    /**
     * Incrémenter le compteur d'annonces utilisées
     */
    public function incrementAnnonceCount(Vendeur $vendeur): void
    {
        $abonnementActif = $vendeur->abonnementActif;

        if ($abonnementActif) {
            $abonnementActif->increment('nombre_annonces_utilisees');
        }
    }

    /**
     * Calculer la commission sur un montant
     */
    public function calculateCommission(float $montant, Vendeur $vendeur): float
    {
        $tauxCommission = $this->getCommissionRate($vendeur);
        
        return round($montant * ($tauxCommission / 100), 2);
    }

    /**
     * Obtenir le nombre d'annonces restantes pour le vendeur
     */
    public function getRemainingAnnonces(Vendeur $vendeur): int|string
    {
        $abonnementActif = $vendeur->abonnementActif;

        if (!$abonnementActif) {
            // Abonnement gratuit
            $abonnementGratuit = \App\Models\Abonnement::where('type', \App\Models\Abonnement::TYPE_GRATUIT)->first();
            
            if (!$abonnementGratuit) {
                return 0;
            }

            $nombreAnnonces = $vendeur->annonces()->whereIn('statut', ['publiee', 'en_attente'])->count();
            
            return max(0, $abonnementGratuit->nombre_annonces - $nombreAnnonces);
        }

        $abonnement = $abonnementActif->abonnement;

        // Si illimité (nombre_annonces = 0)
        if ($abonnement->nombre_annonces === 0) {
            return 'illimité';
        }

        return max(0, $abonnement->nombre_annonces - $abonnementActif->nombre_annonces_utilisees);
    }

    /**
     * Vérifier si le vendeur a un abonnement payant actif
     */
    public function hasPaidSubscription(Vendeur $vendeur): bool
    {
        $abonnementActif = $vendeur->abonnementActif;

        if (!$abonnementActif) {
            return false;
        }

        return $abonnementActif->abonnement->prix_mensuel > 0;
    }
}
