<?php

namespace App\Policies;

use App\Models\Copropriete;
use App\Models\Syndic;
use App\Models\User;

class CoproprietePolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des résidences.
     * Il a le droit s'il a la permission globale, OU au moins une affectation
     * spécifique sur une résidence OU sur un syndic parent.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('copropriete:voir');
    }

    /**
     * Détermine si l'utilisateur peut voir une résidence spécifique.
     * La logique contextuelle (y compris la remontée depuis le syndic parent)
     * est gérée par la méthode hasPermissionTo.
     */
    public function view(User $user, Copropriete $copropriete): bool
    {
        return $user->hasPermissionTo('copropriete:voir', $copropriete);
    }

    /**
     * Détermine si l'utilisateur peut créer des résidences.
     * C'est une permission globale.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('copropriete:creer');
    }

    /**
     * Détermine si l'utilisateur peut modifier une résidence.
     */
    public function update(User $user, Copropriete $copropriete): bool
    {
        return $user->hasPermissionTo('copropriete:modifier', $copropriete);
    }

    /**
     * Détermine si l'utilisateur peut supprimer une résidence.
     */
    public function delete(User $user, Copropriete $copropriete): bool
    {
        return $user->hasPermissionTo('copropriete:supprimer', $copropriete);
    }
}
