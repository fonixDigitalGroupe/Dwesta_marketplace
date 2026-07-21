<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'reporter_id',
        'email',
        'motif',
        'description',
        'statut',
    ];

    /**
     * Libellés lisibles des motifs de signalement.
     */
    public const MOTIFS = [
        'contrefacon' => 'Produit contrefait / faux',
        'interdit' => 'Produit interdit ou illégal',
        'arnaque' => 'Arnaque ou tentative de fraude',
        'contenu_inapproprie' => 'Contenu inapproprié ou offensant',
        'description_trompeuse' => 'Description ou prix trompeur',
        'autre' => 'Autre',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonce_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function getMotifLibelleAttribute(): string
    {
        return self::MOTIFS[$this->motif] ?? $this->motif;
    }
}
