<?php
namespace App\Policies;
use App\Models\Copropriete;
use App\Models\User;
class CoproprietePolicy
{
    public function viewAny(User $user): bool { return $user->hasPermissionTo('copropriete:voir'); }
    public function view(User $user, Copropriete $copropriete): bool { return $user->hasPermissionTo('copropriete:voir', $copropriete); }
    public function create(User $user): bool { return $user->hasPermissionTo('copropriete:creer'); }
    public function update(User $user, Copropriete $copropriete): bool { return $user->hasPermissionTo('copropriete:modifier', $copropriete); }
    public function delete(User $user, Copropriete $copropriete): bool { return $user->hasPermissionTo('copropriete:supprimer', $copropriete); }
}
