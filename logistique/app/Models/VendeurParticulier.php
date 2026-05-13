<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendeurParticulier extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendeur_id',
        'type_document',
        'numero_document',
        'document_path',
        'date_expiration_document',
        'date_emission_document',
        'lieu_emission',
    ];

    protected $casts = [
        'date_expiration_document' => 'date',
        'date_emission_document' => 'date',
    ];

    /**
     * Relation avec le vendeur
     */
    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }

    /**
     * Vérifier si le document est expiré
     */
    public function estExpire(): bool
    {
        if (!$this->date_expiration_document) {
            return false;
        }
        
        return $this->date_expiration_document->isPast();
    }

    /**
     * Vérifier si le document expire bientôt (dans 30 jours)
     */
    public function expireBientot(): bool
    {
        if (!$this->date_expiration_document) {
            return false;
        }
        
        return $this->date_expiration_document->isBefore(now()->addDays(30));
    }
}
