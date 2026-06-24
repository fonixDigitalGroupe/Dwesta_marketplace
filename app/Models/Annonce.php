<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendeur_id',
        'categorie_id',
        'type',
        'titre',
        'slug',
        'prix',
        'description',
        'type_livraison',
        'disponibilite',
        'nb_photos',
        'video_achetee',
        'statut',
        'raison_rejet',
        'publiee_le',
        'expire_le',
        'prix_original',
        'coupon_code',
        'promo_expires_at',
        'vues',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'prix_original' => 'decimal:2',
        'nb_photos' => 'integer',
        'video_achetee' => 'boolean',
        'vues' => 'integer',
        'publiee_le' => 'datetime',
        'expire_le' => 'datetime',
        'promo_expires_at' => 'datetime',
    ];

    // Types d'annonces
    const TYPE_PRODUIT = 'produit';
    const TYPE_SERVICE = 'service';
    const TYPE_IMMOBILIER = 'immobilier';
    const TYPE_VEHICULE = 'vehicule';

    // Statuts
    const STATUT_BROUILLON = 'brouillon';
    const STATUT_EN_ATTENTE = 'en_attente';
    const STATUT_PUBLIEE = 'publiee';
    const STATUT_REJETEE = 'rejetee';
    const STATUT_EXPIREE = 'expiree';

    // Disponibilité
    const DISPONIBILITE_EN_STOCK = 'en_stock';
    const DISPONIBILITE_RUPTURE_STOCK = 'rupture_stock';
    const DISPONIBILITE_SUR_COMMANDE = 'sur_commande';

    /**
     * Relation avec le vendeur
     */
    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }

    /**
     * Relation avec la catégorie
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    /**
     * Alias pour la relation catégorie (nom anglais)
     */
    public function category(): BelongsTo
    {
        return $this->categorie();
    }

    /**
     * Relation avec les médias (photos/vidéos)
     */
    public function medias(): HasMany
    {
        return $this->hasMany(AnnonceMedia::class)->orderBy('ordre');
    }

    /**
     * Relation avec les photos uniquement
     */
    public function photos(): HasMany
    {
        return $this->hasMany(AnnonceMedia::class)
            ->where('type', 'photo')
            ->orderBy('ordre');
    }

    /**
     * Relation avec la vidéo
     */
    public function video(): HasOne
    {
        return $this->hasOne(AnnonceMedia::class)
            ->where('type', 'video');
    }

    /**
     * Relation avec les options payantes
     */
    public function options(): HasOne
    {
        return $this->hasOne(AnnonceOption::class);
    }

    /**
     * Relation avec les variantes (tailles, couleurs, etc.)
     */
    public function variantes(): HasMany
    {
        return $this->hasMany(AnnonceVariante::class);
    }

    /**
     * Relation avec les avis clients
     */
    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class);
    }

    /**
     * Relation avec les avis approuvés uniquement
     */
    public function avisApprouves(): HasMany
    {
        return $this->hasMany(Avis::class)->where('statut', Avis::STATUT_APPROUVE);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Obtenir la note moyenne de l'annonce
     */
    public function getNoteMoyenneAttribute(): float
    {
        $avisApprouves = $this->avisApprouves;
        if ($avisApprouves->count() === 0) {
            return 0;
        }
        return round($avisApprouves->avg('note'), 1);
    }

    /**
     * Obtenir le nombre d'avis approuvés
     */
    public function getNombreAvisAttribute(): int
    {
        return $this->avisApprouves()->count();
    }

    /**
     * Relations avec les types spécifiques
     */
    public function produit(): HasOne
    {
        return $this->hasOne(AnnonceProduit::class);
    }

    public function service(): HasOne
    {
        return $this->hasOne(AnnonceService::class);
    }

    public function immobilier(): HasOne
    {
        return $this->hasOne(AnnonceImmobilier::class);
    }

    public function vehicule(): HasOne
    {
        return $this->hasOne(AnnonceVehicule::class);
    }

    /**
     * Vérifier si l'annonce est publiée
     */
    public function estPubliee(): bool
    {
        return $this->statut === self::STATUT_PUBLIEE;
    }

    /**
     * Vérifier si l'annonce est expirée
     */
    public function estExpiree(): bool
    {
        return $this->expire_le && $this->expire_le->isPast();
    }

    /**
     * Vérifier si l'annonce est en brouillon
     */
    public function estBrouillon(): bool
    {
        return $this->statut === self::STATUT_BROUILLON;
    }

    /**
     * Obtenir la photo principale
     */
    public function photoPrincipale(): ?AnnonceMedia
    {
        return $this->photos()->where('est_principale', true)->first()
            ?? $this->photos()->first();
    }

    /**
     * Obtenir l'état brut (slug)
     */
    public function getEtatAttribute(): ?string
    {
        if ($this->type === self::TYPE_PRODUIT && $this->produit) {
            return $this->produit->etat;
        } elseif ($this->type === self::TYPE_VEHICULE && $this->vehicule) {
            return $this->vehicule->etat;
        }
        return null;
    }

    /**
     * Détermine si l'état doit être affiché
     */
    public function getShouldShowEtatAttribute(): bool
    {
        $famille = $this->category->famille ?? null;
        return !($famille === Category::FAMILLE_SERVICES || $famille === Category::FAMILLE_IMMOBILIER);
    }

    /**
     * Retourne la couleur associée à l'état
     */
    public function getEtatCouleurAttribute()
    {
        $famille = $this->category->famille ?? null;
        if ($famille === Category::FAMILLE_SERVICES || $famille === Category::FAMILLE_IMMOBILIER) {
            return 'transparent';
        }

        return match($this->etat) {
            'neuf' => '#28a745', // Vert
            'reconditionne' => '#007bff', // Bleu
            'occasion' => '#d32f2f', // Rouge
            default => '#565959',
        };
    }

    /**
     * Obtenir le libellé de l'état (Neuf/Occasion)
     */
    /**
     * Retourne le libellé du bouton "Voir" selon la famille de catégorie
     */
    public function getLabelVoirBoutonAttribute()
    {
        $famille = $this->category->famille ?? null;
        
        return match($famille) {
            'Services' => 'Voir le service',
            'Immobilier' => 'Voir l\'annonce',
            default => 'Voir le produit',
        };
    }

    public function getEtatLibelleAttribute(): string
    {
        $famille = $this->category->famille ?? null;
        if ($famille === Category::FAMILLE_SERVICES || $famille === Category::FAMILLE_IMMOBILIER) {
            return '';
        }

        $etat = $this->etat;

        if (!$etat) {
            return 'Occasion';
        }

        $labels = [
            'neuf'          => 'Neuf',
            'occasion'      => 'Occasion',
            'reconditionne' => 'Reconditionné',
            'reconditionné' => 'Reconditionné',
            'comme_neuf'    => 'Comme neuf',
        ];

        return $labels[$etat] ?? ucfirst(str_replace('_', ' ', $etat));
    }

    public function filteredAttributes(): HasMany
    {
        return $this->hasMany(AnnonceAttribute::class);
    }

    /**
     * Incrémenter le compteur de vues
     */
    public function incrementerVues(): void
    {
        $this->increment('vues');
    }

    /**
     * Obtenir le pourcentage de réduction
     */
    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->prix_original || $this->prix_original <= $this->prix) {
            return 0;
        }
        return (int) round((($this->prix_original - $this->prix) / $this->prix_original) * 100);
    }

    /**
     * Vérifier si l'annonce est en promotion active
     */
    public function estEnPromo(): bool
    {
        return $this->prix_original > $this->prix && 
               (!$this->promo_expires_at || $this->promo_expires_at->isFuture());
    }

    /**
     * Scope pour les annonces en promotion
     */
    public function scopeEnPromotion($query)
    {
        return $query->whereNotNull('prix_original')
            ->whereColumn('prix_original', '>', 'prix')
            ->where(function ($q) {
                $q->whereNull('promo_expires_at')
                    ->orWhere('promo_expires_at', '>', now());
            });
    }

    /**
     * Vérifier si l'annonce a l'option "À la Une" active
     */
    public function aLaUneActive(): bool
    {
        if (!$this->relationLoaded('options')) {
            $this->load('options');
        }
        return $this->options && $this->options->aLaUneActive();
    }

    /**
     * Vérifier si l'annonce a l'option "Urgent" active
     */
    public function urgentActive(): bool
    {
        if (!$this->relationLoaded('options')) {
            $this->load('options');
        }
        return $this->options && $this->options->urgentActive();
    }

    /**
     * Vérifier si l'annonce a l'option "Vidéo" active
     */
    public function videoActive(): bool
    {
        if (!$this->relationLoaded('options')) {
            $this->load('options');
        }
        return $this->options && $this->options->videoActive();
    }

    /**
     * Alias pour aLaUneActive()
     */
    public function estALaUne(): bool
    {
        return $this->aLaUneActive();
    }

    /**
     * Alias pour urgentActive()
     */
    public function estUrgent(): bool
    {
        return $this->urgentActive();
    }

    /**
     * Scopes
     */
    public function scopePubliees($query)
    {
        return $query->where('statut', self::STATUT_PUBLIEE)
            ->whereNotNull('publiee_le')
            ->where(function ($q) {
                $q->whereNull('expire_le')
                    ->orWhere('expire_le', '>', now());
            });
    }

    public function scopeParType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeParCategorie($query, int $categorieId)
    {
        return $query->where('categorie_id', $categorieId);
    }

    /**
     * Scope pour les annonces des vendeurs professionnels
     */
    public function scopeProfessionnelles($query)
    {
        return $query->whereHas('vendeur', function ($q) {
            $q->where('type', 'professionnel');
        });
    }

    /**
     * Scope pour les annonces "À la Une"
     */
    public function scopeALaUne($query)
    {
        return $query->whereHas('options', function ($q) {
            $q->where('a_la_une', true)
                ->where(function ($q2) {
                    $q2->whereNull('a_la_une_expire_le')
                        ->orWhere('a_la_une_expire_le', '>', now());
                });
        });
    }

    /**
     * Scope pour les annonces "Urgent"
     */
    public function scopeUrgentes($query)
    {
        return $query->whereHas('options', function ($q) {
            $q->where('urgent', true)
                ->where(function ($q2) {
                    $q2->whereNull('urgent_expire_le')
                        ->orWhere('urgent_expire_le', '>', now());
                });
        });
    }

    /**
     * Générer un slug unique
     */
    public static function generateSlug(string $titre, ?int $ignoreId = null): string
    {
        $slug = Str::slug($titre);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'annonce_id', 'user_id')->withTimestamps();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Vérifie si l'annonce peut être ajoutée au panier.
     * Seuls les produits de la famille E-commerce sont achetables en ligne.
     */
    public function peutEtreAchete(): bool
    {
        if (!$this->relationLoaded('category')) {
            $this->load('category');
        }

        return $this->category && $this->category->famille === Category::FAMILLE_ECOMMERCE;
    }
}
