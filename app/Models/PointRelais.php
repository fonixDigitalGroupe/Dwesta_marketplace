<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointRelais extends Model
{
    protected $table = 'point_relais';

    protected $fillable = [
        'nom',
        'adresse',
        'pays',
        'region',
        'latitude',
        'longitude',
        'google_maps_url',
        'telephone',
        'horaires',
        'is_active',
        'est_point_special',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'est_point_special' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'point_relais_user');
    }
}
