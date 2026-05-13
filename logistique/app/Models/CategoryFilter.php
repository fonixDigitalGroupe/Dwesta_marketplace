<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'nom',
        'slug',
        'type',
        'options',
        'unit',
        'is_filterable',
        'is_required',
        'ordre',
    ];

    protected $casts = [
        'options' => 'array',
        'is_filterable' => 'boolean',
        'is_required' => 'boolean',
        'ordre' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(AnnonceAttribute::class);
    }
}
