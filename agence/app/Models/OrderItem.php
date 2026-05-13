<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'annonce_id',
        'annonce_variante_id',
        'quantite',
        'prix_unitaire',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function variante()
    {
        return $this->belongsTo(AnnonceVariante::class, 'annonce_variante_id');
    }
}
