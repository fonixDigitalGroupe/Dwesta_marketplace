<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'vendeur_id',
        'reference',
        'total_produits',
        'frais_port',
        'commission_plateforme',
        'total_final',
        'statut',
        'adresse_livraison',
        'mode_livraison',
        'tracking_token',
        'qr_code_token',
        'qr_code_path',
        'notes_vendeur',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(Vendeur::class, 'vendeur_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
