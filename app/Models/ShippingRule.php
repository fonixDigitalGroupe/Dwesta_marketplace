<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_country_id',
        'destination_country_id',
        'zone_name',
        'delivery_type',
        'price',
        'delivery_delay',
        'is_active',
    ];

    public function sourceCountry()
    {
        return $this->belongsTo(Country::class, 'source_country_id');
    }

    public function destinationCountry()
    {
        return $this->belongsTo(Country::class, 'destination_country_id');
    }

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    const TYPE_DOMICILE = 'domicile';
    const TYPE_POINT_RELAIS = 'point_relais';

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
