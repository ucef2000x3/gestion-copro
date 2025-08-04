<?php
namespace App\Policies;
use App\Models\Residence;
use App\Models\User;
class ResidencePolicy
{
    public function viewAny(User $user): bool { return $user->hasPermissionTo('residence:voir'); }
    public function view(User $user, Residence $residence): bool { return $user->hasPermissionTo('residence:voir', $residence); }
    public function create(User $user): bool { return $user->hasPermissionTo('residence:creer'); }
    public function update(User $user, Residence $residence): bool { return $user->hasPermissionTo('residence:modifier', $residence); }
    public function delete(User $user, Residence $residence): bool { return $user->hasPermissionTo('residence:supprimer', $residence); }
}
