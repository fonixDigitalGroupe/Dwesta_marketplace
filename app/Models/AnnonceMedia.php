<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class AnnonceMedia extends Model
{
    use HasFactory;

    /**
     * Nom de la table associée au modèle
     */
    protected $table = 'annonce_medias';

    protected $fillable = [
        'annonce_id',
        'type',
        'chemin',
        'nom_original',
        'taille',
        'mime_type',
        'ordre',
        'est_principale',
    ];

    protected $casts = [
        'taille' => 'integer',
        'ordre' => 'integer',
        'est_principale' => 'boolean',
    ];

    // Types de médias
    const TYPE_PHOTO = 'photo';
    const TYPE_VIDEO = 'video';

    /**
     * Relation avec l'annonce
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

    /**
     * Obtenir l'URL du média
     */
    public function getUrlAttribute(): string
    {
        return '/storage/' . $this->chemin;
    }

    /**
     * Obtenir l'URL du thumbnail (pour les photos)
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->estPhoto()) {
            return null;
        }

        $thumbnailPath = str_replace('/photos/', '/thumbnails/', $this->chemin);
        
        if (Storage::disk('public')->exists($thumbnailPath)) {
            return '/storage/' . $thumbnailPath;
        }

        // Si pas de thumbnail, retourner l'image originale
        return $this->url;
    }

    /**
     * Obtenir le chemin complet du fichier
     */
    public function getFullPathAttribute(): string
    {
        return Storage::disk('public')->path($this->chemin);
    }

    /**
     * Vérifier si c'est une photo
     */
    public function estPhoto(): bool
    {
        return $this->type === self::TYPE_PHOTO;
    }

    /**
     * Vérifier si c'est une vidéo
     */
    public function estVideo(): bool
    {
        return $this->type === self::TYPE_VIDEO;
    }
}
