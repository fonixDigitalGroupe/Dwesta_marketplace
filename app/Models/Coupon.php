<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'is_active',
        'category_id',
        'banner_image',
        'category_id_n1',
        'category_id_n2',
        'landing_page_image',
        'seller_type',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categoryN1()
    {
        return $this->belongsTo(Category::class, 'category_id_n1');
    }

    public function categoryN2()
    {
        return $this->belongsTo(Category::class, 'category_id_n2');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    /**
     * Calcule le prix remisé pour un prix de base donné, selon ce coupon.
     */
    public function prixRemise(float $base): float
    {
        if ($this->type === 'percent') {
            return round($base * (1 - $this->value / 100), 2);
        }

        return round(max(0, $base - $this->value), 2);
    }

    /**
     * (Ré)applique la remise de ce coupon aux annonces adhérentes : le prix barré
     * (prix_original) sert de base, le prix devient le prix remisé. Idempotent.
     * Utilisé quand le coupon (re)devient actif.
     */
    public function reappliquerAuxAnnonces(): void
    {
        Annonce::where('coupon_code', $this->code)
            ->whereNotNull('prix_original')
            ->get()
            ->each(function (Annonce $annonce) {
                $annonce->update(['prix' => $this->prixRemise((float) $annonce->prix_original)]);
            });
    }

    /**
     * Rétablit le prix initial (prix_original) des annonces adhérentes.
     * Les champs coupon_code / prix_original sont conservés afin de garder la
     * trace de l'adhésion (statut « inactif » dans le tableau adhérents).
     * Utilisé quand le coupon est désactivé.
     */
    public function retablirPrixAnnonces(): void
    {
        Annonce::where('coupon_code', $this->code)
            ->whereNotNull('prix_original')
            ->whereColumn('prix', '<', 'prix_original')
            ->update(['prix' => DB::raw('prix_original')]);
    }
}
