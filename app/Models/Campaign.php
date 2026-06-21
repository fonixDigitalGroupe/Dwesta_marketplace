<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'target_type',
        'subject',
        'message',
        'sent_count',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
