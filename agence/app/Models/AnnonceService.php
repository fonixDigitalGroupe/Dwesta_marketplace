<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnonceService extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'type_tarification',
        'tarif_horaire',
        'duree_estimee',
        'deplacement_inclus',
        'zone_intervention',
    ];

    protected $casts = [
        'tarif_horaire' => 'decimal:2',
        'deplacement_inclus' => 'boolean',
    ];

    // Types de tarification
    const TARIF_FIXE = 'fixe';
    const TARIF_HORAIRE = 'horaire';
    const TARIF_DEVIS = 'devis';

    /**
     * Relation avec l'annonce
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }
}
