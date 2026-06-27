<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transporteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_vehicule',
        'marque_vehicule',
        'modele_vehicule',
        'photo_vehicule',
        'immatriculation',
        'numero_permis',
        'numero_cni',
        'permis_recto',
        'permis_verso',
        'cni_recto',
        'cni_verso',
        'carte_grise',
        'assurance',
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
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Vérifier si le transporteur est vérifié
     */
    public function estVerifie(): bool
    {
        return $this->statut_verification === 'verifie';
    }
}
