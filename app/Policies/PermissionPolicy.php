<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;

class PermissionPolicy
{
    // Normalement, seul un super-admin devrait pouvoir gérer les permissions.
    // Pour l'instant, nous gardons la logique standard.
    // Vous pourriez ajouter une vérification `$user->hasRole('Super Admin')` ici plus tard.

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('permission:voir'); // Permission pour voir les permissions
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('permission:voir');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('permission:creer');
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('permission:modifier');
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('permission:supprimer');
    }
}
