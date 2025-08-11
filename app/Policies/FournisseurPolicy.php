<?php

namespace App\Policies;

use App\Models\Fournisseur;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FournisseurPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des fournisseurs.
     * Pour l'instant, c'est un droit global.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('fournisseur:voir');
    }

    /**
     * Détermine si l'utilisateur peut voir un fournisseur spécifique.
     */
    public function view(User $user, Fournisseur $fournisseur): bool
    {
        return $user->hasPermissionTo('fournisseur:voir');
    }

    /**
     * Détermine si l'utilisateur peut créer des fournisseurs.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('fournisseur:creer');
    }

    /**
     * Détermine si l'utilisateur peut modifier un fournisseur.
     */
    public function update(User $user, Fournisseur $fournisseur): bool
    {
        return $user->hasPermissionTo('fournisseur:modifier');
    }

    /**
     * Détermine si l'utilisateur peut supprimer un fournisseur.
     */
    public function delete(User $user, Fournisseur $fournisseur): bool
    {
        return $user->hasPermissionTo('fournisseur:supprimer');
    }
}
