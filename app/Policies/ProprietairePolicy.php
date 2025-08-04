<?php

namespace App\Policies;

use App\Models\Proprietaire;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProprietairePolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des propriétaires.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('proprietaire:voir');
    }

    /**
     * Détermine si l'utilisateur peut voir un propriétaire spécifique.
     */
    public function view(User $user, Proprietaire $proprietaire): bool
    {
        // La vérification contextuelle se fera plus tard en fonction
        // des lots que le gestionnaire a le droit de voir.
        // Pour l'instant, on se base sur la permission globale.
        return $user->hasPermissionTo('proprietaire:voir');
    }

    /**
     * Détermine si l'utilisateur peut créer des propriétaires.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('proprietaire:creer');
    }

    /**
     * Détermine si l'utilisateur peut modifier un propriétaire.
     */
    public function update(User $user, Proprietaire $proprietaire): bool
    {
        return $user->hasPermissionTo('proprietaire:modifier');
    }

    /**
     * Détermine si l'utilisateur peut supprimer un propriétaire.
     */
    public function delete(User $user, Proprietaire $proprietaire): bool
    {
        return $user->hasPermissionTo('proprietaire:supprimer');
    }
}
