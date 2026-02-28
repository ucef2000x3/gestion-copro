<?php
namespace App\Policies;
use App\Models\OperationDiverse;
use App\Models\User;
class OperationDiversePolicy
{
    public function viewAny(User $user): bool { return $user->hasPermissionTo('operation_diverse:voir'); }
    public function create(User $user): bool { return $user->hasPermissionTo('operation_diverse:creer'); }
    public function update(User $user, OperationDiverse $operation): bool { return $user->hasPermissionTo('operation_diverse:modifier', $operation->copropriete); }
    public function delete(User $user, OperationDiverse $operation): bool { return $user->hasPermissionTo('operation_diverse:supprimer', $operation->copropriete); }
}
