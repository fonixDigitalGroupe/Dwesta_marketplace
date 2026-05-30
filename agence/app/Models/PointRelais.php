<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointRelais extends Model
{
    protected $table = 'point_relais';

    protected $fillable = [
        'nom',
        'email',
        'adresse',
        'pays',
        'region',
        'google_maps_url',
        'telephone',
        'horaires',
        'is_active',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'horaires'  => 'array',
        'is_active' => 'boolean',
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'point_relais_user');
    }
}
