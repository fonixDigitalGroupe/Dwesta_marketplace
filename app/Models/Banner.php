<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'famille',

        'category_id',
        'image_url',
        'link_url',
        'promo_discount',
        'promo_conditions',
        'promo_code',
        'has_payment_4x',
        'active',
        'order',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'active' => 'boolean',
        'has_payment_4x' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'order' => 'integer',
    ];

    /**
     * Scope for active banners
     */
    public function scopeActive($query)
    {
        return $query->where('active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }
}
