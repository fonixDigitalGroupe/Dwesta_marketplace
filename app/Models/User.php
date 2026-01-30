<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'civilite',
        'prenom',
        'nom',
        'date_de_naissance',
        'nationalite',
        'telephone',
        'email',
        'credit_balance',
        'adresse',
        'code_postal',
        'password',
        'is_active',
        'avatar',
        'provider',
        'provider_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'telephone_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_de_naissance' => 'date',
        ];
    }

    /**
     * Relation avec le vendeur (si l'utilisateur est vendeur)
     */
    public function vendeur(): HasOne
    {
        return $this->hasOne(Vendeur::class);
    }

    /**
     * Vérifier si l'utilisateur est vendeur
     */
    public function estVendeur(): bool
    {
        return $this->vendeur !== null;
    }

    /**
     * Vérifier si l'utilisateur est vendeur vérifié
     */
    public function estVendeurVerifie(): bool
    {
        return $this->vendeur && $this->vendeur->estVerifie();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function creditTransactions()
    {
        return $this->hasMany(CreditTransaction::class);
    }

    /**
     * Conversations où l'utilisateur est user1
     */
    public function conversationsAsUser1()
    {
        return $this->hasMany(Conversation::class, 'user1_id');
    }

    /**
     * Conversations où l'utilisateur est user2
     */
    public function conversationsAsUser2()
    {
        return $this->hasMany(Conversation::class, 'user2_id');
    }

    /**
     * Obtenir toutes les conversations de l'utilisateur
     */
    public function getConversationsAttribute()
    {
        return Conversation::where('user1_id', $this->id)
            ->orWhere('user2_id', $this->id)
            ->orderBy('last_message_at', 'desc')
            ->get();
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function favorites()
    {
        return $this->belongsToMany(Annonce::class, 'favorites', 'user_id', 'annonce_id')->withTimestamps();
    }

    /**
     * Solde disponible (déjà libéré)
     */
    public function getAvailableBalanceAttribute(): int
    {
        return $this->credit_balance;
    }

    /**
     * Solde en attente (séquestré)
     * Somme des transactions 'pending' liées à cet utilisateur
     */
    public function getPendingBalanceAttribute(): int
    {
        return $this->hasMany(Transaction::class)->where('wallet_status', Transaction::STATUS_PENDING)->sum('montant');
    }
}
