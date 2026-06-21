<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'is_active',
        'category_id',
        'banner_image',
        'page_image',
        'category_id_n1',
        'category_id_n2',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categoryN1()
    {
        return $this->belongsTo(Category::class, 'category_id_n1');
    }

    public function categoryN2()
    {
        return $this->belongsTo(Category::class, 'category_id_n2');
    }
}
