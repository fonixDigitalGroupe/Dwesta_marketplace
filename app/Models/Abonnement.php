<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    protected $fillable = [
        'type',
        'nom',
        'description',
        'nombre_annonces',
        'commission',
        'prix_mensuel',
        'page_pro',
        'page_pro_personnalisable',
        'actif',
        'ordre',
    ];

    protected $casts = [
        'page_pro' => 'boolean',
        'page_pro_personnalisable' => 'boolean',
        'actif' => 'boolean',
    ];

    public function vendeurAbonnements()
    {
        return $this->hasMany(VendeurAbonnement::class);
    }
}
