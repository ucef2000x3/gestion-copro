<?php
namespace App\Policies;
use App\Models\TypeDePoste;
use App\Models\User;
class TypeDePostePolicy
{
    public function viewAny(User $user): bool { return $user->hasPermissionTo('type_poste:voir'); }
    public function view(User $user, TypeDePoste $typeDePoste): bool { return $user->hasPermissionTo('type_poste:voir', $typeDePoste->copropriete); }
    public function create(User $user): bool { return $user->hasPermissionTo('type_poste:creer'); }
    public function update(User $user, TypeDePoste $typeDePoste): bool { return $user->hasPermissionTo('type_poste:modifier', $typeDePoste->copropriete); }
    public function delete(User $user, TypeDePoste $typeDePoste): bool { return $user->hasPermissionTo('type_poste:supprimer', $typeDePoste->copropriete); }
}
