<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompteBancaire;
use App\Models\Copropriete;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompteBancaireController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', CompteBancaire::class);
        $comptes = CompteBancaire::with('copropriete')->latest()->paginate(15);
        return view('admin.comptes-bancaires.index', compact('comptes'));
    }

    public function create()
    {
        $this->authorize('create', CompteBancaire::class);
        $coproprietes = Copropriete::actif()->orderBy('nom_copropriete')->get();
        return view('admin.comptes-bancaires.create', compact('coproprietes'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', CompteBancaire::class);
        $validated = $request->validate($this->validationRules());
        CompteBancaire::create($validated);
        return redirect()->route('comptes-bancaires.index')->with('success', 'Compte / Caisse créé avec succès.');
    }

    public function edit(CompteBancaire $compteBancaire)
    {
        $this->authorize('update', $compteBancaire);
        $coproprietes = Copropriete::orderBy('nom_copropriete')->get();
        return view('admin.comptes-bancaires.edit', compact('compteBancaire', 'coproprietes'));
    }

    public function update(Request $request, CompteBancaire $compteBancaire)
    {
        $this->authorize('update', $compteBancaire);
        $validated = $request->validate($this->validationRules($compteBancaire));
        $compteBancaire->update($validated);
        return redirect()->route('comptes-bancaires.index')->with('success', 'Compte / Caisse mis à jour avec succès.');
    }

    public function destroy(CompteBancaire $compteBancaire)
    {
        $this->authorize('delete', $compteBancaire);
        // Ajouter une vérification : ne pas supprimer si des mouvements existent.
        $compteBancaire->delete();
        return redirect()->route('comptes-bancaires.index')->with('success', 'Compte / Caisse supprimé avec succès.');
    }

    /**
     * Centralise les règles de validation.
     */
    protected function validationRules(?CompteBancaire $compteBancaire = null): array
    {
        return [
            'id_copropriete' => 'required|exists:coproprietes,id_copropriete',
            'type_compte' => ['required', Rule::in(['banque', 'caisse'])],
            'nom_compte' => 'required|string|max:255',
            'iban' => [
                'nullable',
                'string',
                'max:255',
                // L'IBAN doit être unique, en ignorant l'enregistrement actuel lors d'une modification
                Rule::unique('comptes_bancaires', 'iban')->ignore($compteBancaire?->id_compte_bancaire, 'id_compte_bancaire')
            ],
            'nom_banque' => 'nullable|string|max:255',
            'solde_initial' => 'required|numeric',
            'statut' => 'required|boolean',
        ];
    }
}
