<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livreur extends Model
{
    protected $fillable = [
        'user_id',
        'matricule',
        'type_vehicule',
        'type_document',
        'numero_document',
        'document_recto',
        'document_verso',
        'statut_verification',
        'raison_rejet',
        'actif',
        'en_ligne',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'en_ligne' => 'boolean',
    ];

    /**
     * Tout livreur inscrit est activé automatiquement :
     * statut "vérifié" + actif, quel que soit le canal d'inscription.
     */
    protected static function booted(): void
    {
        static::creating(function (Livreur $livreur) {
            $livreur->statut_verification = 'verifie';
            $livreur->actif = true;
        });
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
