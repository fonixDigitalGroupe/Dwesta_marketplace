<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;

    const TYPE_GRATUIT = 'gratuit';
    const TYPE_BASIC = 'basic';
    const TYPE_EXPERT = 'expert';

    // Familles (alignées sur App\Models\Category)
    const FAMILLE_ECOMMERCE  = 'E-commerce';
    const FAMILLE_SERVICES   = 'Services';
    const FAMILLE_IMMOBILIER = 'Immobilier';
    const FAMILLE_VEHICULES  = 'Véhicules';

    /** Familles pour lesquelles la publication d'annonce exige un abonnement actif. */
    public static function famillesRequierentAbonnement(): array
    {
        return [self::FAMILLE_SERVICES, self::FAMILLE_IMMOBILIER, self::FAMILLE_VEHICULES];
    }

    public static function familles(): array
    {
        return [self::FAMILLE_ECOMMERCE, self::FAMILLE_SERVICES, self::FAMILLE_IMMOBILIER, self::FAMILLE_VEHICULES];
    }

    protected $fillable = [
        'type',
        'famille',
        'nom',
        'description',
        'nombre_annonces',
        'limite_chiffre_affaires',
        'commission',
        'prix_mensuel',
        'duree_jours',
        'page_pro',
        'page_pro_personnalisable',
        'actif',
        'ordre',
        'stripe_price_id',
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
