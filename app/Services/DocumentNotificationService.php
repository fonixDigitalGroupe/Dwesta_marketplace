<?php

namespace App\Services;

use App\Models\DocumentNotification;
use App\Models\Vendeur;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DocumentNotificationService
{
    /**
     * Jours avant expiration pour envoyer les notifications
     */
    private const JOURS_ALERTE = [30, 15, 7, 1];

    /**
     * Vérifier si une notification doit être envoyée
     *
     * @param Vendeur $vendeur
     * @param string $type Type de document (particulier, professionnel, abonnement)
     * @param Carbon|string $dateExpiration
     * @return bool
     */
    public function doitEnvoyerNotification(Vendeur $vendeur, string $type, $dateExpiration): bool
    {
        if (!$dateExpiration) {
            return false;
        }

        $dateExpiration = $dateExpiration instanceof Carbon ? $dateExpiration : Carbon::parse($dateExpiration);
        $joursRestants = now()->diffInDays($dateExpiration);

        // Vérifier si on est dans une période d'alerte
        if (!in_array($joursRestants, self::JOURS_ALERTE)) {
            return false;
        }

        // Vérifier si une notification a déjà été envoyée pour cette date et ce nombre de jours
        $notificationExistante = DocumentNotification::where('vendeur_id', $vendeur->id)
            ->where('type_document', $type)
            ->where('date_expiration', $dateExpiration->format('Y-m-d'))
            ->where('jours_avant_expiration', $joursRestants)
            ->where('envoyee', true)
            ->exists();

        return !$notificationExistante;
    }

    /**
     * Enregistrer une notification envoyée
     *
     * @param Vendeur $vendeur
     * @param string $type
     * @param Carbon|string $dateExpiration
     * @param int $joursRestants
     * @return DocumentNotification
     */
    public function enregistrerNotification(Vendeur $vendeur, string $type, $dateExpiration, int $joursRestants): DocumentNotification
    {
        $dateExpiration = $dateExpiration instanceof Carbon ? $dateExpiration : Carbon::parse($dateExpiration);
        
        return DocumentNotification::create([
            'vendeur_id' => $vendeur->id,
            'type_document' => $type,
            'date_expiration' => $dateExpiration->format('Y-m-d'),
            'jours_avant_expiration' => $joursRestants,
            'envoyee' => true,
            'envoyee_le' => now(),
            'message' => "Document expirant dans {$joursRestants} jour(s)",
        ]);
    }

    /**
     * Obtenir les alertes actives pour un vendeur
     *
     * @param Vendeur $vendeur
     * @return array
     */
    public function getAlertesActives(Vendeur $vendeur): array
    {
        $alertes = [];

        // Vérifier le document particulier
        if ($vendeur->estParticulier() && $vendeur->particulier) {
            $particulier = $vendeur->particulier;
            if ($particulier->date_expiration_document) {
                $joursRestants = now()->diffInDays($particulier->date_expiration_document);
                
                if ($joursRestants <= 30 && $joursRestants >= 0) {
                    $alertes[] = [
                        'type' => 'particulier',
                        'titre' => 'Document d\'identité',
                        'date_expiration' => $particulier->date_expiration_document,
                        'jours_restants' => $joursRestants,
                        'est_expire' => $particulier->estExpire(),
                        'expire_bientot' => $particulier->expireBientot(),
                    ];
                }
            }
        }

        // Vérifier le registre professionnel
        if ($vendeur->estProfessionnel() && $vendeur->professionnel) {
            $professionnel = $vendeur->professionnel;
            if ($professionnel->date_expiration_registre) {
                $joursRestants = now()->diffInDays($professionnel->date_expiration_registre);
                
                if ($joursRestants <= 30 && $joursRestants >= 0) {
                    $alertes[] = [
                        'type' => 'professionnel',
                        'titre' => 'Registre de commerce',
                        'date_expiration' => $professionnel->date_expiration_registre,
                        'jours_restants' => $joursRestants,
                        'est_expire' => $professionnel->registreExpire(),
                        'expire_bientot' => $professionnel->registreExpireBientot(),
                    ];
                }
            }
        }

        // Vérifier l'abonnement
        if ($vendeur->abonnementActif) {
            $abonnementActif = $vendeur->abonnementActif;
            $joursRestants = now()->diffInDays($abonnementActif->date_fin);
            
            if ($joursRestants <= 30 && $joursRestants >= 0) {
                $alertes[] = [
                    'type' => 'abonnement',
                    'titre' => 'Abonnement ' . $abonnementActif->abonnement->nom,
                    'date_expiration' => $abonnementActif->date_fin,
                    'jours_restants' => $joursRestants,
                    'est_expire' => $abonnementActif->estExpire(),
                    'expire_bientot' => $abonnementActif->expireBientot(),
                ];
            }
        }

        return $alertes;
    }
}

