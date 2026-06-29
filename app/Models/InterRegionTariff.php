<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterRegionTariff extends Model
{
    protected $fillable = [
        'country_id',
        'delivery_type',
        'same_region_price',
        'inter_region_price',
        'delivery_delay',
        'is_active',
    ];

    protected $casts = [
        'same_region_price' => 'decimal:2',
        'inter_region_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
