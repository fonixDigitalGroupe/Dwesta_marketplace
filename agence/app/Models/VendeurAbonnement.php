<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VendeurAbonnement extends Model
{
    protected $fillable = [
        'vendeur_id',
        'abonnement_id',
        'date_debut',
        'date_fin',
        'actif',
        'renouvellement_automatique',
        'nombre_annonces_utilisees',
        'metadata',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'actif' => 'boolean',
        'renouvellement_automatique' => 'boolean',
        'metadata' => 'array',
    ];

    public function vendeur()
    {
        return $this->belongsTo(Vendeur::class);
    }

    public function abonnement()
    {
        return $this->belongsTo(Abonnement::class);
    }

    public function estActif(): bool
    {
        return $this->actif && $this->date_fin >= Carbon::today();
    }

    public function estExpire(): bool
    {
        return $this->date_fin < Carbon::today();
    }

    /**
     * Vérifier si l'abonnement expire bientôt (dans 30 jours)
     */
    public function expireBientot(): bool
    {
        if (!$this->date_fin) {
            return false;
        }

        return $this->date_fin->isBefore(now()->addDays(30)) && !$this->estExpire();
    }

    /**
     * Vérifier si le vendeur peut publier une nouvelle annonce
     * selon les limites de son abonnement (basé sur le nombre d'annonces actives)
     */
    public function peutPublierAnnonce(): bool
    {
        $abonnement = $this->abonnement;

        // Si nombre_annonces = 0, c'est illimité
        if ($abonnement->nombre_annonces === 0 || $abonnement->nombre_annonces === null) {
            return true;
        }

        // Sinon, vérifier le nombre d'annonces RÉELLEMENT actives en base
        $nombreAnnoncesActives = $this->vendeur->annonces()
            ->whereIn('statut', ['publiee', 'en_attente'])
            ->count();

        return $nombreAnnoncesActives < $abonnement->nombre_annonces;
    }
}
