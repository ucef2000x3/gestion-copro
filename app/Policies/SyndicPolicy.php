<?php

namespace App\Policies;

use App\Models\Syndic;
use App\Models\User;

class SyndicPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des syndics.
     * L'utilisateur a le droit s'il possède la permission globale 'syndic:voir'
     * OU s'il a une affectation spécifique sur au moins un syndic.
     */
    public function viewAny(User $user): bool
    {
        // Vérifie d'abord la permission globale.
        if ($user->hasPermissionTo('syndic:voir')) {
            return true;
        }

        // Sinon, vérifie s'il existe au moins une affectation pour cet utilisateur
        // dont le périmètre est un objet de type Syndic.
        // Cela lui donne le droit de voir la page de liste (qui sera ensuite filtrée).
        return $user->affectations()->where('affectable_type', Syndic::class)->exists();
    }

    /**
     * Détermine si l'utilisateur peut voir un syndic spécifique.
     * La logique contextuelle est gérée par la méthode hasPermissionTo.
     */
    public function view(User $user, Syndic $syndic): bool
    {
        return $user->hasPermissionTo('syndic:voir', $syndic);
    }

    /**
     * Détermine si l'utilisateur peut créer des syndics.
     * C'est une permission globale.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('syndic:creer');
    }

    /**
     * Détermine si l'utilisateur peut modifier un syndic.
     */
    public function update(User $user, Syndic $syndic): bool
    {
        return $user->hasPermissionTo('syndic:modifier', $syndic);
    }

    /**
     * Détermine si l'utilisateur peut supprimer un syndic.
     */
    public function delete(User $user, Syndic $syndic): bool
    {
        return $user->hasPermissionTo('syndic:supprimer', $syndic);
    }
}
