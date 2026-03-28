<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreditPack extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'credits',
        'bonus_credits',
        'prix',
        'actif',
        'ordre',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'credits' => 'integer',
        'bonus_credits' => 'integer',
        'prix' => 'integer',
    ];

    /**
     * Total de crédits obtenus à l'achat (inclus le bonus)
     */
    public function getTotalCreditsAttribute(): int
    {
        return $this->credits + $this->bonus_credits;
    }

    public function scopeActif($query)
    {
        return $query->where('actif', true)->orderBy('ordre');
    }
}
