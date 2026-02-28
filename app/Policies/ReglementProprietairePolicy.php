<?php
namespace App\Policies;
use App\Models\ReglementProprietaire;
use App\Models\User;
class ReglementProprietairePolicy
{
    public function viewAny(User $user): bool { return $user->hasPermissionTo('reglement_proprio:voir'); }
    public function create(User $user): bool { return $user->hasPermissionTo('reglement_proprio:creer'); }
    public function update(User $user, ReglementProprietaire $reglement): bool { return $user->hasPermissionTo('reglement_proprio:modifier', $reglement->exercice->copropriete); }
    public function delete(User $user, ReglementProprietaire $reglement): bool { return $user->hasPermissionTo('reglement_proprio:supprimer', $reglement->exercice->copropriete); }
}
