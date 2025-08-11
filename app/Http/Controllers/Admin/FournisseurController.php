<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Fournisseur::class);
        $fournisseurs = Fournisseur::latest()->paginate(15);
        return view('admin.fournisseurs.index', compact('fournisseurs'));
    }

    public function create()
    {
        $this->authorize('create', Fournisseur::class);
        return view('admin.fournisseurs.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Fournisseur::class);
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:fournisseurs',
            'statut' => 'required|boolean',
        ]);
        Fournisseur::create($validated);
        return redirect()->route('fournisseurs.index')->with('success', __('Fournisseur créé avec succès !'));
    }

    public function edit(Fournisseur $fournisseur)
    {
        $this->authorize('update', $fournisseur);
        return view('admin.fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $this->authorize('update', $fournisseur);
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:fournisseurs,nom,' . $fournisseur->id_fournisseur . ',id_fournisseur',
            'statut' => 'required|boolean',
        ]);
        $fournisseur->update($validated);
        return redirect()->route('fournisseurs.index')->with('success', __('Fournisseur mis à jour avec succès !'));
    }

    public function destroy(Fournisseur $fournisseur)
    {
        $this->authorize('delete', $fournisseur);
        // On ajoutera la vérification des factures liées plus tard.
        // if ($fournisseur->factures()->exists()) {
        //     return back()->with('error', 'Impossible de supprimer, ce fournisseur a des factures.');
        // }
        $fournisseur->delete();
        return redirect()->route('fournisseurs.index')->with('success', __('Fournisseur supprimé avec succès !'));
    }
}
