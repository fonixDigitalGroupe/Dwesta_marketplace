<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditServiceConfig extends Model
{
    protected $fillable = [
        'cle',
        'nom',
        'description',
        'credits_requis',
        'duree_jours',
        'actif',
        'ordre',
    ];

    protected $casts = [
        'actif'         => 'boolean',
        'credits_requis' => 'integer',
        'duree_jours'   => 'integer',
    ];

    public function scopeActif($query)
    {
        return $query->where('actif', true)->orderBy('ordre');
    }

    /**
     * Calcule la date d'expiration à partir d'aujourd'hui.
     * Retourne null si le service est permanent.
     */
    public function calculerExpiration(): ?\Carbon\Carbon
    {
        return $this->duree_jours ? now()->addDays($this->duree_jours) : null;
    }
}
