<?php

namespace App\Policies;

use App\Models\CompteBancaire;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompteBancairePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('compte_bancaire:voir');
    }

    public function view(User $user, CompteBancaire $compteBancaire): bool
    {
        // L'utilisateur peut voir un compte s'il a le droit de voir la copropriété parente.
        return $user->hasPermissionTo('compte_bancaire:voir', $compteBancaire->copropriete);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('compte_bancaire:creer');
    }

    public function update(User $user, CompteBancaire $compteBancaire): bool
    {
        return $user->hasPermissionTo('compte_bancaire:modifier', $compteBancaire->copropriete);
    }

    public function delete(User $user, CompteBancaire $compteBancaire): bool
    {
        return $user->hasPermissionTo('compte_bancaire:supprimer', $compteBancaire->copropriete);
    }
}
