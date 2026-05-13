<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnonceCreditService extends Model
{
    protected $fillable = [
        'annonce_id',
        'service',
        'credits_depenses',
        'demarre_le',
        'expire_le',
    ];

    protected $casts = [
        'demarre_le' => 'datetime',
        'expire_le'  => 'datetime',
        'credits_depenses' => 'integer',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    /**
     * Scope : services en cours (pas encore expirés)
     */
    public function scopeActif($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expire_le')->orWhere('expire_le', '>', now());
        });
    }

    public function estActif(): bool
    {
        return is_null($this->expire_le) || $this->expire_le->isFuture();
    }
}
