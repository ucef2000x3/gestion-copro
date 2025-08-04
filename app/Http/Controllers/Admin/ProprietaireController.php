<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proprietaire;
use App\Models\User;
use Illuminate\Http\Request;

class ProprietaireController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Proprietaire::class);
        $proprietaires = Proprietaire::with('utilisateur')->latest()->paginate(15);
        return view('admin.proprietaires.index', compact('proprietaires'));
    }

    public function create()
    {
        $this->authorize('create', Proprietaire::class);
        // On récupère les utilisateurs qui ne sont pas encore liés à un profil propriétaire
        $users = User::whereDoesntHave('proprietaire')->orderBy('name')->get();
        return view('admin.proprietaires.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Proprietaire::class);
        $validated = $request->validate($this->getValidationRules());
        Proprietaire::create($validated);
        return redirect()->route('proprietaires.index')->with('success', 'Propriétaire créé avec succès !');
    }

    public function edit(Proprietaire $proprietaire)
    {
        $this->authorize('update', $proprietaire);
        // On récupère les utilisateurs non liés, PLUS l'utilisateur actuellement lié à ce profil (s'il y en a un)
        $users = User::whereDoesntHave('proprietaire')
            ->orWhere('id', $proprietaire->id_utilisateur)
            ->orderBy('name')->get();
        return view('admin.proprietaires.edit', compact('proprietaire', 'users'));
    }

    public function update(Request $request, Proprietaire $proprietaire)
    {
        $this->authorize('update', $proprietaire);
        $validated = $request->validate($this->getValidationRules($proprietaire));
        $proprietaire->update($validated);
        return redirect()->route('proprietaires.index')->with('success', 'Propriétaire mis à jour avec succès !');
    }

    public function destroy(Proprietaire $proprietaire)
    {
        $this->authorize('delete', $proprietaire);
        if ($proprietaire->lots()->exists()) {
            return back()->with('error', 'Impossible de supprimer, ce propriétaire possède encore des lots.');
        }
        $proprietaire->delete();
        return redirect()->route('proprietaires.index')->with('success', 'Propriétaire supprimé avec succès !');
    }

    /**
     * Centralise les règles de validation pour le modèle Proprietaire.
     */
    protected function getValidationRules(?Proprietaire $proprietaire = null): array
    {
        return [
            'type_proprietaire' => 'required|in:personne_physique,personne_morale',
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone_contact' => 'nullable|string|max:255',
            'adresse_postale' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:10',
            'ville' => 'nullable|string|max:255',
            'statut' => 'required|boolean',
            'id_utilisateur' => 'nullable|exists:users,id',
            // Ajoutez ici les autres champs...
        ];
    }
}
