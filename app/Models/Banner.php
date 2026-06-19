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
        'category_id_n1',
        'category_id_n2',
        'image_url',
        'landing_page_image',
        'link_url',
        'promo_discount',
        'promo_conditions',
        'promo_code',
        'has_payment_4x',
        'is_promo',
        'active',
        'order',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_promo' => 'boolean',
        'active' => 'boolean',
        'has_payment_4x' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'order' => 'integer',
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'banner_category')->withPivot('description');
    }

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
