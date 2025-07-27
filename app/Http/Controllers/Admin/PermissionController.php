<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::latest()->paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cle' => 'required|string|max:255|unique:permissions,cle',
            'nom_permission.fr' => 'required|string|max:255',
            'nom_permission.en' => 'nullable|string|max:255',
        ]);

        Permission::create($validated);

        return redirect()->route('permissions.index')->with('success', 'Permission créée avec succès !');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'cle' => 'required|string|max:255|unique:permissions,cle,' . $permission->id_permission . ',id_permission',
            'nom_permission.fr' => 'required|string|max:255',
            'nom_permission.en' => 'nullable|string|max:255',
        ]);

        $permission->update($validated);

        return redirect()->route('permissions.index')->with('success', 'Permission mise à jour avec succès !');
    }

    public function destroy(Permission $permission)
    {
        // Ajouter une vérification pour les rôles liés avant de supprimer.
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission supprimée avec succès !');
    }
}
