<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    protected $fillable = [
        'code',
        'amount',
        'balance',
        'status',
        'buyer_id',
        'user_id',
        'redeemed_at',
        'expiry_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'redeemed_at' => 'datetime',
        'expiry_date' => 'date',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function redeemer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Generate a unique gift card code.
     */
    public static function generateCode()
    {
        do {
            $code = strtoupper(\Illuminate\Support\Str::random(4) . '-' . \Illuminate\Support\Str::random(4) . '-' . \Illuminate\Support\Str::random(4));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
