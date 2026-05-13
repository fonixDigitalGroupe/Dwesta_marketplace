<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'user_id',
        'commande_id',
        'note',
        'commentaire',
        'photos',
        'statut',
        'raison_rejet',
        'modere_par',
        'modere_le',
    ];

    protected $casts = [
        'note' => 'integer',
        'photos' => 'array',
        'modere_le' => 'datetime',
    ];

    // Statuts
    const STATUT_EN_ATTENTE = 'en_attente';
    const STATUT_APPROUVE = 'approuve';
    const STATUT_REJETE = 'rejete';

    /**
     * Relation avec l'annonce
     */
    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }

    /**
     * Relation avec l'utilisateur (acheteur)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le modérateur (admin)
     */
    public function moderateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modere_par');
    }

    /**
     * Vérifier si l'avis est approuvé
     */
    public function estApprouve(): bool
    {
        return $this->statut === self::STATUT_APPROUVE;
    }

    /**
     * Vérifier si l'avis est en attente
     */
    public function estEnAttente(): bool
    {
        return $this->statut === self::STATUT_EN_ATTENTE;
    }

    /**
     * Vérifier si l'avis est rejeté
     */
    public function estRejete(): bool
    {
        return $this->statut === self::STATUT_REJETE;
    }

    /**
     * Scope pour les avis approuvés
     */
    public function scopeApprouves($query)
    {
        return $query->where('statut', self::STATUT_APPROUVE);
    }

    /**
     * Scope pour les avis en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', self::STATUT_EN_ATTENTE);
    }
}
