<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OperationDiverse;
use App\Models\Copropriete;
use App\Enums\StatutExercice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OperationDiverseController extends Controller
{
    /**
     * Affiche la liste des opérations diverses.
     */
    public function index()
    {
        $this->authorize('viewAny', OperationDiverse::class);

        $operations = OperationDiverse::with(['copropriete', 'exercice', 'typeDePoste'])
            ->latest('date_operation')
            ->paginate(15);

        return view('admin.operations-diverses.index', compact('operations'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $this->authorize('create', OperationDiverse::class);

        // On charge les copropriétés avec leurs dépendances pour les menus dynamiques
        $coproprietes = Copropriete::actif()
            ->with([
                'exercices' => fn($q) => $q->where('statut', '!=', StatutExercice::Cloture->value),
                'typesDePoste' => fn($q) => $q->where('statut', true)
            ])
            ->orderBy('nom_copropriete')->get();

        return view('admin.operations-diverses.create', compact('coproprietes'));
    }

    /**
     * Enregistre une nouvelle opération diverse.
     */
    public function store(Request $request)
    {
        $this->authorize('create', OperationDiverse::class);

        $validated = $request->validate([
            'id_copropriete' => 'required|exists:coproprietes,id_copropriete',
            'id_exercice' => 'required|exists:exercices,id_exercice',
            'id_type_poste' => 'required|exists:types_de_poste,id_type_poste',
            'type_operation' => ['required', Rule::in(['Depense', 'Recette'])],
            'montant' => 'required|numeric|min:0.01',
            'libelle' => 'required|string|max:255',
            'date_operation' => 'required|date',
            'tiers' => 'nullable|string|max:255',
        ]);

        OperationDiverse::create($validated);

        // Plus tard, cette action déclenchera des écritures comptables et de trésorerie.

        return redirect()->route('operations-diverses.index')->with('success', 'Opération diverse enregistrée avec succès.');
    }

    /**
     * Affiche le formulaire de modification.
     */
    public function edit(OperationDiverse $operationDiverse)
    {
        // Laravel utilise le "camel case" du nom de la ressource pour la variable,
        // donc `operations-diverses` devient `$operationDiverse`.
        $this->authorize('update', $operationDiverse);

        $coproprietes = Copropriete::with([
            'exercices' => fn($q) => $q->where('statut', '!=', StatutExercice::Cloture->value),
            'typesDePoste' => fn($q) => $q->where('statut', true)
        ])
            ->orderBy('nom_copropriete')->get();

        return view('admin.operations-diverses.edit', compact('operationDiverse', 'coproprietes'));
    }

    /**
     * Met à jour une opération diverse.
     */
    public function update(Request $request, OperationDiverse $operationDiverse)
    {
        $this->authorize('update', $operationDiverse);

        $validated = $request->validate([
            'id_copropriete' => 'required|exists:coproprietes,id_copropriete',
            'id_exercice' => 'required|exists:exercices,id_exercice',
            'id_type_poste' => 'required|exists:types_de_poste,id_type_poste',
            'type_operation' => ['required', Rule::in(['Depense', 'Recette'])],
            'montant' => 'required|numeric|min:0.01',
            'libelle' => 'required|string|max:255',
            'date_operation' => 'required|date',
            'tiers' => 'nullable|string|max:255',
        ]);

        $operationDiverse->update($validated);

        return redirect()->route('operations-diverses.index')->with('success', 'Opération diverse mise à jour avec succès.');
    }

    /**
     * Supprime une opération diverse.
     */
    public function destroy(OperationDiverse $operationDiverse)
    {
        $this->authorize('delete', $operationDiverse);
        $operationDiverse->delete();
        return redirect()->route('operations-diverses.index')->with('success', 'Opération diverse supprimée avec succès.');
    }
}
