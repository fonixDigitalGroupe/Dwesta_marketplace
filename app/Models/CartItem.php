<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'annonce_id',
        'annonce_variante_id',
        'quantite',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
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
