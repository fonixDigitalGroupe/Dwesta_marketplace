<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnonceProduit extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'prix_moyen_marche',
        'badges',
        'marque',
        'modele',
        'etat',
        'quantite',
    ];

    protected $casts = [
        'prix_moyen_marche' => 'decimal:2',
        'badges' => 'array',
        'quantite' => 'integer',
    ];

    /**
     * Relation avec l'annonce
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

    /**
     * Vérifier si le prix est inférieur au prix moyen marché
     */
    public function estMoinsCherQueMarche(): bool
    {
        if (!$this->prix_moyen_marche || !$this->annonce->prix) {
            return false;
        }
        return $this->annonce->prix < $this->prix_moyen_marche;
    }
}
