<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Détermine si l'utilisateur actuel peut voir la liste des utilisateurs.
     */
    public function viewAny(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('utilisateur:voir');
    }

    /**
     * Détermine si l'utilisateur actuel peut voir le profil d'un autre utilisateur.
     */
    public function view(User $currentUser, User $targetUser): bool
    {
        return $currentUser->hasPermissionTo('utilisateur:voir');
    }

    /**
     * Note: Il n'y a pas de méthode 'create' ici car la création se fait via l'inscription publique.
     * Si vous ajoutiez un bouton "Créer un utilisateur" dans l'admin,
     * vous ajouteriez la méthode suivante :
     *
     * public function create(User $currentUser): bool
     * {
     *     return $currentUser->hasPermissionTo('utilisateur:creer');
     * }
     */

    /**
     * Détermine si l'utilisateur actuel peut modifier un utilisateur cible.
     * Cette logique est cruciale pour la sécurité.
     */
    public function update(User $currentUser, User $targetUser): bool
    {
        // Règle n°1 : Un Super Admin ne peut pas être modifié par un non-Super Admin.
        // Si la cible est un Super Admin et que l'utilisateur actuel n'en est pas un, on refuse.
        if ($targetUser->isSuperAdmin() && !$currentUser->isSuperAdmin()) {
            return false;
        }

        // Règle n°2 : Un utilisateur peut toujours modifier son propre profil.
        // La page de profil a sa propre logique, mais cette règle est une sécurité supplémentaire.
        if ($currentUser->id === $targetUser->id) {
            return true;
        }

        // Règle n°3 : Sinon, l'utilisateur a besoin de la permission générale
        // pour modifier les autres utilisateurs.
        return $currentUser->hasPermissionTo('utilisateur:modifier');
    }

    /**
     * Détermine si l'utilisateur actuel peut supprimer un utilisateur cible.
     */
    public function delete(User $currentUser, User $targetUser): bool
    {
        // Règle n°1 : On ne peut jamais supprimer un Super Admin.
        if ($targetUser->isSuperAdmin()) {
            return false;
        }

        // Règle n°2 : Un utilisateur ne peut pas se supprimer lui-même via cette interface admin.
        if ($currentUser->id === $targetUser->id) {
            return false;
        }

        // Règle n°3 : Sinon, il a besoin de la permission de suppression.
        return $currentUser->hasPermissionTo('utilisateur:supprimer');
    }

    /**
     * Détermine si l'utilisateur actuel a le droit de voir et de modifier
     * la case à cocher "Super Administrateur" sur la fiche d'un utilisateur.
     */
    public function assignSuperAdmin(User $currentUser): bool
    {
        // Seul un Super Administrateur peut accorder (ou retirer) ce statut.
        return $currentUser->isSuperAdmin();
    }
}
