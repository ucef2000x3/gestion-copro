<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_role.fr' => 'required|string|max:255',
            'nom_role.en' => 'nullable|string|max:255',
        ]);
        Role::create($validated);
        return redirect()->route('roles.index')->with('success', 'Rôle créé avec succès !');
    }

    public function edit(Role $role)
    {
        // La logique cruciale est ici
        $permissions = Permission::orderBy('cle')->get();
        $role->load('permissions');
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'nom_role.fr' => 'required|string|max:255',
            'nom_role.en' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id_permission',
        ]);

        $role->update(['nom_role' => $request->input('nom_role')]); // Mise à jour du nom
        $role->permissions()->sync($request->input('permissions', [])); // Mise à jour des permissions

        return redirect()->route('roles.index')->with('success', 'Rôle mis à jour avec succès !');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rôle supprimé avec succès !');
    }
}
