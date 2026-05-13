<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendeurProfessionnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendeur_id',
        'nom_entreprise',
        'numero_registre_commerce',
        'registre_commerce_path',
        'date_expiration_registre',
        'numero_identification_fiscale',
        'adresse_entreprise',
        'telephone_entreprise',
        'email_entreprise',
        'description_entreprise',
        'site_web',
    ];

    protected $casts = [
        'date_expiration_registre' => 'date',
    ];

    /**
     * Relation avec le vendeur
     */
    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }

    /**
     * Vérifier si le registre de commerce est expiré
     */
    public function registreExpire(): bool
    {
        if (!$this->date_expiration_registre) {
            return false;
        }
        
        return $this->date_expiration_registre->isPast();
    }

    /**
     * Vérifier si le registre expire bientôt (dans 30 jours)
     */
    public function registreExpireBientot(): bool
    {
        if (!$this->date_expiration_registre) {
            return false;
        }
        
        return $this->date_expiration_registre->isBefore(now()->addDays(30));
    }
}
