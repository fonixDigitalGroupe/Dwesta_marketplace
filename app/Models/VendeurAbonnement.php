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
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'actif' => 'boolean',
        'renouvellement_automatique' => 'boolean',
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
}
