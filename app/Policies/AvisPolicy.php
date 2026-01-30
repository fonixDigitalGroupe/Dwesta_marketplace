<?php

namespace App\Policies;

use App\Models\Avis;
use App\Models\User;

class AvisPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Seuls les admins peuvent voir tous les avis
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Avis $avis): bool
    {
        // Tout le monde peut voir les avis approuvés
        // Les admins peuvent voir tous les avis
        return $avis->estApprouve() || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Tous les utilisateurs connectés peuvent créer un avis
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Avis $avis): bool
    {
        // Seuls les admins peuvent modifier les avis (pour modération)
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Avis $avis): bool
    {
        // L'utilisateur peut supprimer son propre avis, ou les admins peuvent supprimer n'importe quel avis
        return $user->id === $avis->user_id || $user->hasRole('admin');
    }
}
