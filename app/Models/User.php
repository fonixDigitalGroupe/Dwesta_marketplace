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
        'password',
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
}
