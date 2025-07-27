<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Langue;
use App\Models\Residence;
use App\Models\Role;
use App\Models\Syndic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::with('roles')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Affiche le formulaire de modification d'un utilisateur avec toutes les données nécessaires.
     */
    public function edit(User $user)
    {
        // On vérifie si l'utilisateur actuel a le droit de modifier l'utilisateur cible.
        $this->authorize('update', $user);

        // On charge les relations nécessaires en une seule fois pour optimiser.
        $user->load('roles', 'affectations.role', 'affectations.affectable');

        // On récupère toutes les données nécessaires pour les menus déroulants et les cases à cocher.
        $allRoles = Role::orderBy('id_role')->get();
        $userGlobalRoleIds = $user->roles->pluck('id_role')->toArray();
        $syndics = Syndic::orderBy('nom_entreprise')->get();
        $residences = Residence::orderBy('nom_residence')->get();
        $langues = Langue::where('est_active', true)->orderBy('nom')->get();

        // On envoie toutes ces données à la vue en utilisant un tableau associatif (plus lisible).
        return view('admin.users.edit', [
            'user' => $user,
            'allRoles' => $allRoles,
            'userGlobalRoleIds' => $userGlobalRoleIds,
            'syndics' => $syndics,
            'residences' => $residences,
            'langues' => $langues,
        ]);
    }

    /**
     * Met à jour les informations de base ET les rôles globaux de l'utilisateur.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        // Valider les informations de base du profil
        $validatedProfile = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            // La validation pour la langue est gérée par le ProfileUpdateRequest,
            // mais on pourrait la dupliquer ici pour plus de sécurité.
            'id_langue_preferee' => ['nullable', 'integer', 'exists:langues,id_langue'],
        ]);

        // On ne met à jour que les champs validés qui sont dans la requête.
        $user->update($request->only('name', 'email', 'id_langue_preferee'));

        // Valider et synchroniser les rôles globaux
        $validatedRoles = $request->validate(['roles' => 'nullable|array']);
        $user->roles()->sync($validatedRoles['roles'] ?? []);

        // Gérer la case Super Admin si l'utilisateur actuel a le droit
        if (auth()->user()->isSuperAdmin()) {
            $user->is_super_admin = $request->has('is_super_admin');
            $user->save();
        }

        return redirect()->route('users.edit', $user)->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
