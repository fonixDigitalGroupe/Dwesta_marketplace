<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCredit extends Model
{
    protected $fillable = ['user_id', 'credits_disponibles'];

    protected $casts = [
        'credits_disponibles' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retourne le solde de l'utilisateur donné (0 si pas encore de ligne)
     */
    public static function soldeFor(int $userId): int
    {
        return static::where('user_id', $userId)->value('credits_disponibles') ?? 0;
    }
}
