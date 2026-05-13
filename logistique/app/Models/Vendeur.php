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
        if ($this->statut_verification === 'verifie') {
            return true;
        }

        // Si c'est un passage de Particulier vérifié à Professionnel (en attente ou rejeté)
        // On considère qu'il garde ses avantages de particulier tant que le pro n'est pas validé
        if ($this->estParticulier() && $this->verifie_le !== null && $this->professionnel()->exists()) {
            return true;
        }

        return false;
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

        // Cas spécial : en cours de passage vers Pro
        if ($this->professionnel()->exists()) {
            return true;
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
     * Vérifier si le vendeur a un forfait payant (Basic ou Expert) actif
     */
    public function aForfaitPayantActif(): bool
    {
        $abonnement = $this->getAbonnementActuelAttribute();
        return $abonnement && $abonnement->type !== Abonnement::TYPE_GRATUIT;
    }

    /**
     * Obtenir l'abonnement actif ou l'abonnement gratuit par défaut
     */
    public function getAbonnementActuelAttribute()
    {
        $abonnementActif = $this->abonnementActif;

        // Si le vendeur n'est pas vérifié, il est limité à l'abonnement gratuit
        if (!$this->estVerifie()) {
            return Abonnement::where('type', Abonnement::TYPE_GRATUIT)->first();
        }

        if ($abonnementActif) {
            return $abonnementActif->abonnement;
        }

        // Retourner l'abonnement gratuit par défaut
        return Abonnement::where('type', Abonnement::TYPE_GRATUIT)->first();
    }

    /**
     * Vérifier si le vendeur peut publier une annonce
     */
    public function peutPublierAnnonce(): bool
    {
        if ($this->statut_verification === 'rejete') {
            return false;
        }

        // Un vendeur pro DOIT avoir un forfait payant pour bénéficier des services
        if ($this->estProfessionnel() && $this->estVerifie() && !$this->aForfaitPayantActif()) {
            return false;
        }

        // Si non vérifié, forcer l'usage des limites de l'abonnement gratuit
        if (!$this->estVerifie()) {
            $abonnementGratuit = Abonnement::where('type', Abonnement::TYPE_GRATUIT)->first();
            if (!$abonnementGratuit) return false;
            
            // On compte les annonces actives (publiées ou en attente)
            $count = $this->annonces()->whereIn('statut', ['publiee', 'en_attente'])->count();
            return $abonnementGratuit->nombre_annonces === 0 || $count < $abonnementGratuit->nombre_annonces;
        }

        $abonnementActif = $this->abonnementActif;

        if (!$abonnementActif) {
            // Si pas d'abonnement actif, utiliser l'abonnement gratuit
            $abonnementGratuit = Abonnement::where('type', Abonnement::TYPE_GRATUIT)->first();
            return $abonnementGratuit && ($abonnementGratuit->nombre_annonces === 0 || $this->annonces()->whereIn('statut', ['publiee', 'en_attente'])->count() < $abonnementGratuit->nombre_annonces);
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
        // Seuls les vendeurs vérifiés peuvent avoir accès aux avantages Page Pro de leur forfait
        if (!$this->estVerifie()) {
            return false;
        }

        // Un vendeur pro DOIT avoir un forfait payant pour bénéficier des services
        if ($this->estProfessionnel() && !$this->aForfaitPayantActif()) {
            return false;
        }

        if ($this->estProfessionnel()) {
            return true;
        }

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
        // Restriction aux vendeurs vérifiés
        if (!$this->estVerifie()) {
            return false;
        }

        // Un vendeur pro DOIT avoir un forfait payant pour bénéficier des services
        if ($this->estProfessionnel() && !$this->aForfaitPayantActif()) {
            return false;
        }

        if ($this->estProfessionnel()) {
            return true;
        }

        $abonnementActif = $this->abonnementActif;

        if (!$abonnementActif) {
            return false;
        }

        return $abonnementActif->abonnement->page_pro_personnalisable === true;
    }

    public function getIdentiteAttribute(): string
    {
        if ($this->pagePro && $this->pagePro->nom_boutique) {
            return $this->pagePro->nom_boutique;
        }

        if ($this->estProfessionnel() && $this->professionnel) {
            return $this->professionnel->nom_entreprise;
        }
        return $this->user ? $this->user->name : 'Vendeur';
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
