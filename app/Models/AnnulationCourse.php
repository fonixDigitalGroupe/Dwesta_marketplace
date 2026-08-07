<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnulationCourse extends Model
{
    protected $table = 'annulations_courses';

    protected $fillable = [
        'order_id',
        'reference',
        'user_id',
        'type',
        'motif',
        'commentaire',
        'statut',
    ];

    /** Le partenaire (livreur/transporteur) qui a annulé. */
    public function partenaire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
