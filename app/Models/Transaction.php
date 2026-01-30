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

    // Statuts du portefeuille
    const STATUS_NONE = 'none';
    const STATUS_PENDING = 'pending';
    const STATUS_AVAILABLE = 'available';
    const STATUS_WITHDRAWN = 'withdrawn';

    /**
     * Scope pour les fonds en attente (séquestrés)
     */
    public function scopePending($query)
    {
        return $query->where('wallet_status', self::STATUS_PENDING);
    }

    /**
     * Scope pour les fonds libérés
     */
    public function scopeAvailable($query)
    {
        return $query->where('wallet_status', self::STATUS_AVAILABLE);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
