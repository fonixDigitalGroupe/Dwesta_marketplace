<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnonceVehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'marque',
        'modele',
        'annee',
        'kilometrage',
        'carburant',
        'boite_vitesse',
        'etat',
        'couleur',
        'nombre_portes',
        'puissance',
    ];

    protected $casts = [
        'annee' => 'integer',
        'kilometrage' => 'integer',
        'nombre_portes' => 'integer',
        'puissance' => 'integer',
    ];

    /**
     * Relation avec l'annonce
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

    /**
     * Obtenir le nom complet du véhicule
     */
    public function getNomCompletAttribute(): string
    {
        return trim("{$this->marque} {$this->modele} " . ($this->annee ? "({$this->annee})" : ""));
    }
}
