<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PagePro extends Model
{
    use HasFactory;

    protected $table = 'page_pro';

    protected $fillable = [
        'vendeur_id',
        'slug',
        'logo',
        'banniere',
        'description',
        'categories',
        'telephone_contact',
        'email_contact',
        'site_web',
        'reseaux_sociaux',
        'actif',
        'vues',
    ];

    protected $casts = [
        'categories' => 'array',
        'reseaux_sociaux' => 'array',
        'actif' => 'boolean',
        'vues' => 'integer',
    ];

    /**
     * Relation avec le vendeur
     */
    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }

    /**
     * Générer un slug unique à partir du nom
     */
    public static function generateSlug(string $nom): string
    {
        $slug = Str::slug($nom);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Incrémenter le nombre de vues
     */
    public function incrementerVues(): void
    {
        $this->increment('vues');
    }

    /**
     * Obtenir l'URL de la page pro
     */
    public function getUrlAttribute(): string
    {
        return route('page-pro.show', $this->slug);
    }

    /**
     * Scope pour les pages actives
     */
    public function scopeActives($query)
    {
        return $query->where('actif', true);
    }
}
