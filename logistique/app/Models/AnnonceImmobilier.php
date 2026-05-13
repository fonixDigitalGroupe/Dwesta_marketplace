<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnonceImmobilier extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'type_transaction',
        'prix_vente',
        'loyer_mensuel',
        'charges_mensuelles',
        'surface',
        'nombre_pieces',
        'nombre_chambres',
        'nombre_salles_bain',
        'adresse',
        'ville',
        'code_postal',
        'pays',
        'equipements',
    ];

    protected $casts = [
        'prix_vente' => 'decimal:2',
        'loyer_mensuel' => 'decimal:2',
        'charges_mensuelles' => 'decimal:2',
        'surface' => 'integer',
        'nombre_pieces' => 'integer',
        'nombre_chambres' => 'integer',
        'nombre_salles_bain' => 'integer',
        'equipements' => 'array',
    ];

    // Types de transaction
    const TRANSACTION_VENTE = 'vente';
    const TRANSACTION_LOCATION = 'location';

    /**
     * Relation avec l'annonce
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

    /**
     * Obtenir le prix selon le type de transaction
     */
    public function getPrixAttribute()
    {
        return $this->type_transaction === self::TRANSACTION_VENTE
            ? $this->prix_vente
            : $this->loyer_mensuel;
    }
}
