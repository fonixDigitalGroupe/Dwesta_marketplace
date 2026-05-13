<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    protected $fillable = [
        'title',
        'type',
        'source_type',
        'limit',
        'order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'limit' => 'integer',
        'order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Récupère les produits pour cette section en fonction de source_type.
     */
    public function getProducts()
    {
        $query = Annonce::publiees();

        switch ($this->source_type) {
            case 'cheapest':
                $query->orderBy('prix', 'asc');
                break;
            case 'most_viewed':
                $query->orderBy('vues', 'desc');
                break;
            case 'flash_sale':
                $query->enPromotion()->orderBy('promo_expires_at', 'asc');
                break;
            case 'manual':
                // Pour une version future : table de pivot pour sélection manuelle
                $query->aLaUne();
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        return $query->take($this->limit)->get();
    }
}
