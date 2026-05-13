<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendeur_id',
        'type_document',
        'date_expiration',
        'jours_avant_expiration',
        'envoyee',
        'envoyee_le',
        'message',
    ];

    protected $casts = [
        'date_expiration' => 'date',
        'jours_avant_expiration' => 'integer',
        'envoyee' => 'boolean',
        'envoyee_le' => 'datetime',
    ];

    /**
     * Relation avec le vendeur
     */
    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }
}
