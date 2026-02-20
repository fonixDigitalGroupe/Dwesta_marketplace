<?php

namespace App\Models;

use App\Models\Abonnement;
use App\Models\PagePro;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vendeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'statut_verification',
        'raison_rejet',
        'verifie_le',
        'verifie_par',
        'actif',
    ];

    protected $casts = [
        'verifie_le' => 'datetime',
        'actif' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le vendeur particulier
     */
    public function particulier(): HasOne
    {
        return $this->hasOne(VendeurParticulier::class);
    }

    /**
     * Relation avec le vendeur professionnel
     */
    public function professionnel(): HasOne
    {
        return $this->hasOne(VendeurProfessionnel::class);
    }

    /**
     * Relation avec l'admin qui a vérifié
     */
    public function verificateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifie_par');
    }

    /**
     * Vérifier si le vendeur est vérifié
     */
    public function estVerifie(): bool
    {
        return $this->statut_verification === 'verifie';
    }

    /**
     * Vérifier si le vendeur est un particulier
     */
    public function estParticulier(): bool
    {
        return $this->type === 'particulier';
    }

    /**
     * Vérifier si le vendeur est un professionnel
     */
    public function estProfessionnel(): bool
    {
        return $this->type === 'professionnel';
    }

    /**
     * Vérifier si le vendeur est un vendeur officiel (formulaire rempli)
     * Par opposition au vendeur auto-créé lors du dépôt d'annonce
     */
    public function estOfficiel(): bool
    {
        if ($this->estProfessionnel()) {
            return true;
        }

        if ($this->estParticulier()) {
            return $this->particulier && $this->particulier->numero_document !== 'A_COMPLETER';
        }

        return false;
    }

    /**
     * Relation avec les abonnements
     */
    public function abonnements(): HasMany
    {
        return $this->hasMany(VendeurAbonnement::class);
    }

    /**
     * Relation avec l'abonnement actif
     */
    public function abonnementActif(): HasOne
    {
        return $this->hasOne(VendeurAbonnement::class)
            ->where('actif', true)
            ->where('date_fin', '>=', now())
            ->latest('date_debut');
    }

    /**
     * Vérifier si le vendeur a un abonnement actif
     */
    public function aAbonnementActif(): bool
    {
        return $this->abonnementActif !== null;
    }

    /**
     * Obtenir l'abonnement actif ou l'abonnement gratuit par défaut
     */
    public function getAbonnementActuelAttribute()
    {
        $abonnementActif = $this->abonnementActif;

        if ($abonnementActif) {
            return $abonnementActif->abonnement;
        }

        // Retourner l'abonnement gratuit par défaut
        return Abonnement::where('type', 'gratuit')->first();
    }

    /**
     * Vérifier si le vendeur peut publier une annonce
     */
    public function peutPublierAnnonce(): bool
    {
        if ($this->statut_verification === 'rejeté') {
            return false;
        }

        $abonnementActif = $this->abonnementActif;

        if (!$abonnementActif) {
            // Si pas d'abonnement actif, utiliser l'abonnement gratuit
            $abonnementGratuit = Abonnement::where('type', 'gratuit')->first();
            return $abonnementGratuit && ($abonnementGratuit->nombre_annonces === 0 || $abonnementGratuit->nombre_annonces > 0);
        }

        return $abonnementActif->peutPublierAnnonce();
    }

    /**
     * Relation avec la page pro
     */
    public function pagePro(): HasOne
    {
        return $this->hasOne(PagePro::class);
    }

    /**
     * Relation avec les annonces
     */
    public function annonces(): HasMany
    {
        return $this->hasMany(Annonce::class);
    }

    /**
     * Relation avec les ventes (commandes reçues)
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Vérifier si le vendeur a accès à la page pro
     */
    public function aAccesPagePro(): bool
    {
        $abonnementActif = $this->abonnementActif;

        if (!$abonnementActif) {
            return false;
        }

        return $abonnementActif->abonnement->page_pro === true;
    }

    /**
     * Vérifier si le vendeur peut personnaliser sa boutique (logo, bannière, etc.)
     * Seuls les vendeurs avec abonnements Basic ou Expert peuvent personnaliser
     */
    public function peutPersonnaliserBoutique(): bool
    {
        $abonnementActif = $this->abonnementActif;

        if (!$abonnementActif) {
            return false;
        }

        return $abonnementActif->abonnement->page_pro_personnalisable === true;
    }

    /**
     * Obtenir l'URL de la boutique publique
     */
    public function getBoutiqueUrl(): ?string
    {
        if (!$this->pagePro) {
            return null;
        }

        return route('page-pro.show', $this->pagePro->slug);
    }
}
