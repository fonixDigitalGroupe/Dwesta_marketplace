<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Litige extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'reporter_id',
        'reported_id',
        'motif',
        'description',
        'statut',
        'resolution',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'commande_id');
    }
}
