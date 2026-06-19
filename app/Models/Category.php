<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * Boot: auto-hérite la famille du parent si non définie
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Category $category) {
            if (empty($category->famille) && $category->parent_id) {
                $parent = self::find($category->parent_id);
                if ($parent) {
                    $category->famille = $parent->getFamilleAttribute();
                }
            }
        });
    }

    protected $fillable = [
        'parent_id',
        'nom',
        'slug',
        'description',
        'icone',
        'image',
        'ordre',
        'actif',
        'famille',
    ];

    // Constantes pour les familles
    const FAMILLE_ECOMMERCE = 'E-commerce';
    const FAMILLE_SERVICES = 'Services';
    const FAMILLE_IMMOBILIER = 'Immobilier';
    const FAMILLE_VEHICULES = 'Véhicules';

    public static function getFamilles(): array
    {
        return [
            self::FAMILLE_ECOMMERCE,
            self::FAMILLE_SERVICES,
            self::FAMILLE_IMMOBILIER,
            self::FAMILLE_VEHICULES,
        ];
    }

    protected $casts = [
        'ordre' => 'integer',
        'actif' => 'boolean',
    ];

    /**
     * Relation avec la catégorie parente
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relation avec les catégories enfants
     */
    public function enfants(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('ordre');
    }

    /**
     * Relation avec les catégories enfants actives
     */
    public function enfantsActifs(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->where('actif', true)
            ->orderBy('ordre');
    }

    /**
     * Vérifier si la catégorie est une catégorie racine (sans parent)
     */
    public function estRacine(): bool
    {
        return $this->parent_id === null;
    }

    /**
     * Vérifier si la catégorie a des enfants
     */
    public function aEnfants(): bool
    {
        return $this->enfants()->count() > 0;
    }

    /**
     * Accesseur récursif pour 'famille'.
     * Si la catégorie courante n'a pas de famille définie,
     * on remonte dans l'arbre pour trouver la famille du parent.
     */
    public function getFamilleAttribute(): ?string
    {
        if (!empty($this->attributes['famille'])) {
            return $this->attributes['famille'];
        }

        if ($this->parent_id) {
            $parent = $this->parent;
            return $parent ? $parent->getFamilleAttribute() : null;
        }

        return null;
    }

    /**
     * Obtenir tous les ancêtres de la catégorie
     */
    public function getAncetresAttribute(): array
    {
        $ancetres = [];
        $categorie = $this->parent;

        while ($categorie) {
            array_unshift($ancetres, $categorie);
            $categorie = $categorie->parent;
        }

        return $ancetres;
    }

    /**
     * Obtenir le chemin complet de la catégorie (breadcrumb)
     */
    public function getCheminAttribute(): string
    {
        $chemin = [$this->nom];
        $categorie = $this->parent;

        while ($categorie) {
            array_unshift($chemin, $categorie->nom);
            $categorie = $categorie->parent;
        }

        return implode(' > ', $chemin);
    }

    /**
     * Générer un slug unique à partir du nom
     */
    public static function generateSlug(string $nom, ?int $parentId = null): string
    {
        $slug = Str::slug($nom);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->where('id', '!=', $parentId)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Scope pour les catégories actives
     */
    public function scopeActives($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Scope pour les catégories racines (sans parent)
     */
    public function scopeRacines($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope pour trier par ordre
     */
    public function scopeParOrdre($query)
    {
        return $query->orderBy('ordre');
    }

    /**
     * Obtenir toutes les catégories sous forme d'arborescence
     */
    public static function getArborescence(): \Illuminate\Support\Collection
    {
        return self::racines()
            ->actives()
            ->parOrdre()
            ->with([
                'enfantsActifs' => function ($query) {
                    $query->parOrdre()->with('enfantsActifs');
                }
            ])
            ->get();
    }

    public function annonces(): HasMany
    {
        return $this->hasMany(Annonce::class, 'categorie_id');
    }

    /**
     * Obtenir tous les IDs des descendants de la catégorie (récursif)
     */
    public function getAllDescendantIds(): \Illuminate\Support\Collection
    {
        $ids = collect([$this->id]);

        foreach ($this->enfantsActifs as $enfant) {
            $ids = $ids->merge($enfant->getAllDescendantIds());
        }

        return $ids->unique();
    }

    /**
     * Obtenir la catégorie et tous ses descendants (récursif)
     * Retourne une collection d'objets Category
     */
    public function descendantsAndSelf(): \Illuminate\Support\Collection
    {
        $categories = collect([$this]);

        foreach ($this->enfantsActifs as $enfant) {
            $categories = $categories->merge($enfant->descendantsAndSelf());
        }

        return $categories;
    }
    /**
     * Décale les ordres d'affichage si nécessaire
     * Si une catégorie utilise un ordre déjà existant au même niveau, décale les suivants.
     */
    public static function shiftOrder(int $newOrder, ?int $parentId, ?int $excludeId = null): void
    {
        // On récupère les catégories au même niveau qui ont un ordre >= au nouvel ordre
        $query = self::where('parent_id', $parentId)
            ->where('ordre', '>=', $newOrder);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        // Si une catégorie existe avec exactement le même ordre, on déclenche le décalage
        $existsSameOrder = (clone $query)->where('ordre', $newOrder)->exists();

        if ($existsSameOrder) {
            // On récupère toutes les catégories à décaler, triées par ordre décroissant pour éviter les conflits temporaires
            $toShift = $query->orderBy('ordre', 'desc')->get();

            foreach ($toShift as $cat) {
                $cat->ordre += 1;
                $cat->save();
            }
        }
    }
    public function filters(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CategoryFilter::class);
    }
    public function banners()
    {
        return $this->belongsToMany(Banner::class, 'banner_category');
    }
}
