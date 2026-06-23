<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'coupon_id',
        'target_type',
        'subject',
        'message',
        'sent_count',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the target URL for the campaign.
     */
    public function getLinkAttribute()
    {
        if ($this->coupon) {
            $cat = $this->coupon->category ?? $this->coupon->categoryN2 ?? $this->coupon->categoryN1;
            if ($cat) {
                return route('search.index', ['category' => $cat->slug]);
            }
        }
        return route('home');
    }
}
