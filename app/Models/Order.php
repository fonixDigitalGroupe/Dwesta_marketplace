<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'vendeur_id',
        'reference',
        'total_produits',
        'frais_port',
        'commission_plateforme',
        'total_final',
        'statut',
        'adresse_livraison',
        'mode_livraison',
        'gestion_paiement',
        'moyen_paiement',
        'destination_point_relais_id',
        'stripe_session_id',
        'stripe_payment_intent_id',
        'paydunya_token',
        'tracking_token',
        'code_livraison',
        'code_ramassage',
        'code_point_relais',
        'qr_code_token',
        'qr_code_path',
        'notes_vendeur',
        'vendeur_vue_le',
    ];

    protected $casts = [
        'vendeur_vue_le' => 'datetime',
    ];

    // Constantes de statut Logistique
    const STATUT_EN_ATTENTE = 'en_attente';
    const STATUT_PAYE = 'paye';
    const STATUT_PRET = 'pret_expedition'; // Préparé par le vendeur
    const STATUT_EN_ROUTE = 'en_route'; // Scanné par le transporteur
    const STATUT_DISPONIBLE = 'disponible'; // Scanné par le relais (Arrivé)
    const STATUT_LIVRE = 'livre'; // Scanné par le relais (Remis au client)
    const STATUT_ANNULE = 'annule';
    const STATUT_LITIGE = 'litige';

    public function getStatutLabelAttribute()
    {
        return match ($this->statut) {
            self::STATUT_EN_ATTENTE => 'En attente de paiement',
            self::STATUT_PAYE => 'Payé (A préparer)',
            self::STATUT_PRET => 'Prêt pour expédition',
            self::STATUT_EN_ROUTE => 'En cours de livraison',
            self::STATUT_DISPONIBLE => 'Disponible au point relais',
            self::STATUT_LIVRE => 'Livré',
            self::STATUT_ANNULE => 'Annulé',
            self::STATUT_LITIGE => 'Litige en cours',
            default => ucfirst($this->statut),
        };
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function destinationPointRelais()
    {
        return $this->belongsTo(\App\Models\PointRelais::class, 'destination_point_relais_id');
    }

    public function seller()
    {
        return $this->belongsTo(Vendeur::class, 'vendeur_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function transporteur()
    {
        return $this->belongsTo(\App\Models\Transporteur::class, 'transporteur_id');
    }

    public function livreur()
    {
        return $this->belongsTo(\App\Models\Livreur::class, 'livreur_id');
    }

    /**
     * Génère un code de confirmation à 4 chiffres (ex. "0473").
     */
    public static function genererCode(): string
    {
        return str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Vrai si la commande est livrée à domicile (vs. retrait point relais).
     */
    public function estLivraisonDomicile(): bool
    {
        return in_array($this->mode_livraison, ['livraison_domicile', 'domicile'], true);
    }

    public function estPointRelais(): bool
    {
        return !$this->estLivraisonDomicile() && ($this->destination_point_relais_id || str_contains((string) $this->mode_livraison, 'relais'));
    }
}
