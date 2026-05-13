<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'montant',
        'description',
        'reference',
        'related_type',
        'related_id',
    ];

    protected $casts = [
        'montant' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function related()
    {
        return $this->morphTo();
    }
}
