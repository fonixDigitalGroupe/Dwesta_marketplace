<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnonceVariante extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'type',
        'valeur',
        'stock',
        'prix_supplementaire',
    ];

    protected $casts = [
        'stock' => 'integer',
        'prix_supplementaire' => 'decimal:2',
    ];

    /**
     * Relation avec l'annonce
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }
}
