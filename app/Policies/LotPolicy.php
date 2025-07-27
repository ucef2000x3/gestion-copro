<?php

namespace App\Policies;

use App\Models\Lot;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LotPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des lots.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('lot:voir');
    }

    /**
     * Détermine si l'utilisateur peut voir un lot spécifique.
     */
    public function view(User $user, Lot $lot): bool
    {
        // La vérification contextuelle se fait en passant le modèle $lot
        return $user->hasPermissionTo('lot:voir', $lot);
    }

    /**
     * Détermine si l'utilisateur peut créer des lots.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('lot:creer');
    }

    /**
     * Détermine si l'utilisateur peut modifier un lot.
     */
    public function update(User $user, Lot $lot): bool
    {
        return $user->hasPermissionTo('lot:modifier', $lot);
    }

    /**
     * Détermine si l'utilisateur peut supprimer un lot.
     */
    public function delete(User $user, Lot $lot): bool
    {
        return $user->hasPermissionTo('lot:supprimer', $lot);
    }
}
