<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proprietaire;
use App\Models\User; // N'oubliez pas l'import
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        // On récupère les utilisateurs qui ne sont pas encore liés à un profil propriétaire.
        $users = User::whereDoesntHave('proprietaire')->orderBy('name')->get();
        return view('admin.proprietaires.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Proprietaire::class);
        $validated = $request->validate($this->getValidationRules());
        Proprietaire::create($validated);
        return redirect()->route('proprietaires.index')->with('success', __('Owner created successfully!'));
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
        return redirect()->route('proprietaires.index')->with('success', __('Owner updated successfully!'));
    }

    public function destroy(Proprietaire $proprietaire)
    {
        $this->authorize('delete', $proprietaire);
        if ($proprietaire->lots()->exists()) {
            return back()->with('error', __('Cannot delete this owner, they still own lots.'));
        }
        $proprietaire->delete();
        return redirect()->route('proprietaires.index')->with('success', __('Owner deleted successfully!'));
    }

    /**
     * Centralise les règles de validation pour le modèle Proprietaire.
     * @param Proprietaire|null $proprietaire L'instance du propriétaire si modification.
     */
    protected function getValidationRules(?Proprietaire $proprietaire = null): array
    {
        // Règles pour personne physique ou morale (selon le type_proprietaire de la requête)
        $type = request()->input('type_proprietaire', 'personne_physique'); // Utilise la valeur du formulaire
        $rules = [
            'type_proprietaire' => 'required|in:personne_physique,personne_morale',
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone_contact' => 'nullable|string|max:255',
            'adresse_postale' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:10',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'commentaires' => 'nullable|string',
            'statut' => 'required|boolean',
            'id_utilisateur' => [
                'nullable',
                'exists:users,id',
                // S'assurer que l'utilisateur lié n'est pas déjà lié à un autre propriétaire
                Rule::unique('proprietaires', 'id_utilisateur')->ignore($proprietaire?->id_proprietaire, 'id_proprietaire')
            ],
        ];

        if ($type === 'personne_physique') {
            $rules['civilite'] = 'nullable|string|max:255';
            $rules['prenom'] = 'nullable|string|max:255';
            $rules['date_naissance'] = 'nullable|date';
        } elseif ($type === 'personne_morale') {
            $rules['forme_juridique'] = 'nullable|string|max:255';
            $rules['numero_siret'] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
