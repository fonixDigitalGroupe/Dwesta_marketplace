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
        'tracking_token',
        'qr_code_token',
        'qr_code_path',
        'notes_vendeur',
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
        return match($this->statut) {
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
}
