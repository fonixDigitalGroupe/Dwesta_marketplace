<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnonceAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'category_filter_id',
        'value',
    ];

    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

    public function filter(): BelongsTo
    {
        return $this->belongsTo(CategoryFilter::class, 'category_filter_id');
    }
}
