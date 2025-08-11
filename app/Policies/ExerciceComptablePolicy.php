<?php

namespace App\Policies;

use App\Models\ExerciceComptable;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExerciceComptablePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('exercice:voir');
    }

    public function view(User $user, ExerciceComptable $exercice): bool
    {
        // L'utilisateur peut voir l'exercice s'il a le droit de voir la copropriété parente.
        return $user->hasPermissionTo('exercice:voir', $exercice->copropriete);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('exercice:creer');
    }

    public function update(User $user, ExerciceComptable $exercice): bool
    {
        return $user->hasPermissionTo('exercice:modifier', $exercice->copropriete);
    }

    public function delete(User $user, ExerciceComptable $exercice): bool
    {
        return $user->hasPermissionTo('exercice:supprimer', $exercice->copropriete);
    }

    /**
     * Règle spéciale pour l'action de clôture.
     */
    public function cloturer(User $user, ExerciceComptable $exercice): bool
    {
        return $user->hasPermissionTo('exercice:cloturer', $exercice->copropriete);
    }
}
