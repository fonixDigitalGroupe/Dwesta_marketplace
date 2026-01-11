<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'reference_externe',
        'montant',
        'moyen_paiement',
        'statut',
        'wallet_status',
        'release_at',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'release_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
