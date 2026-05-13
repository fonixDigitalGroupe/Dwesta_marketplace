<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnonceOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'a_la_une',
        'urgent',
        'video',
        'republication_auto',
        'frais_insertion',
        'a_la_une_expire_le',
        'urgent_expire_le',
        'video_expire_le',
    ];

    protected $casts = [
        'a_la_une' => 'boolean',
        'urgent' => 'boolean',
        'video' => 'boolean',
        'republication_auto' => 'boolean',
        'frais_insertion' => 'decimal:2',
        'a_la_une_expire_le' => 'datetime',
        'urgent_expire_le' => 'datetime',
        'video_expire_le' => 'datetime',
    ];

    /**
     * Relation avec l'annonce
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

    /**
     * Vérifier si l'option "À la Une" est active
     */
    public function aLaUneActive(): bool
    {
        return $this->a_la_une && (!$this->a_la_une_expire_le || $this->a_la_une_expire_le->isFuture());
    }

    /**
     * Vérifier si l'option "Urgent" est active
     */
    public function urgentActive(): bool
    {
        return $this->urgent && (!$this->urgent_expire_le || $this->urgent_expire_le->isFuture());
    }

    /**
     * Vérifier si l'option "Vidéo" est active
     */
    public function videoActive(): bool
    {
        return $this->video && (!$this->video_expire_le || $this->video_expire_le->isFuture());
    }

    /**
     * Obtenir le nombre de jours restants pour "À la Une"
     */
    public function getJoursRestantsALaUneAttribute(): ?int
    {
        if (!$this->a_la_une || !$this->a_la_une_expire_le) {
            return null;
        }

        return max(0, now()->diffInDays($this->a_la_une_expire_le, false));
    }

    /**
     * Obtenir le nombre de jours restants pour "Urgent"
     */
    public function getJoursRestantsUrgentAttribute(): ?int
    {
        if (!$this->urgent || !$this->urgent_expire_le) {
            return null;
        }

        return max(0, now()->diffInDays($this->urgent_expire_le, false));
    }

    /**
     * Obtenir le nombre de jours restants pour "Vidéo"
     */
    public function getJoursRestantsVideoAttribute(): ?int
    {
        if (!$this->video || !$this->video_expire_le) {
            return null;
        }

        return max(0, now()->diffInDays($this->video_expire_le, false));
    }

    /**
     * Vérifier si au moins une option est active
     */
    public function aOptionsActives(): bool
    {
        return $this->aLaUneActive() || $this->urgentActive() || $this->videoActive();
    }
}
