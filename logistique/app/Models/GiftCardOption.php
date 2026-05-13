<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCardOption extends Model
{
    protected $fillable = [
        'amount',
        'description',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];
}
