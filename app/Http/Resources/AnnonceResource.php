<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnonceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'titre'         => $this->titre,
            'slug'          => $this->slug,
            'prix'          => (float) $this->prix_affiche,
            'prix_original' => $this->prix_original ? (float) $this->prix_original : null,
            'en_promo'      => $this->estEnPromo(),
            'type'          => $this->type,
            'famille'       => $this->category?->famille,
            'categorie'     => $this->category?->nom,
            'description'   => $this->when($request->routeIs('api.annonces.show'), $this->description),
            'etat'          => $this->etat_libelle ?? null,
            'disponibilite' => $this->disponibilite,
            'poids_palier'  => $this->poids_palier,
            'note_moyenne'  => round((float) $this->note_moyenne, 1),
            'nombre_avis'   => (int) $this->nombre_avis,
            'photo'         => $this->photoPrincipale()?->url,
            'photos'        => $this->when(
                $request->routeIs('api.annonces.show'),
                fn () => $this->photos->map(fn ($p) => $p->url)->values()
            ),
            'vendeur'       => [
                'id'        => $this->vendeur?->id,
                'nom'       => $this->vendeur?->identite,
                'type'      => $this->vendeur?->type,
                'boutique'  => $this->vendeur?->type === 'professionnel' ? $this->vendeur?->getBoutiqueUrl() : null,
            ],
            'peut_etre_achete' => $this->peutEtreAchete(),
            'cree_le'       => $this->created_at?->toIso8601String(),
        ];
    }
}
