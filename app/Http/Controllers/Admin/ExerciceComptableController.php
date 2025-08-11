<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatutExercice;
use Illuminate\Validation\Rules\Enum;
use App\Http\Controllers\Controller;
use App\Models\Copropriete;
use App\Models\ExerciceComptable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExerciceComptableController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ExerciceComptable::class);
        $exercices = ExerciceComptable::with('copropriete')->latest()->paginate(15);
        return view('admin.exercices.index', compact('exercices'));
    }

    public function create()
    {
        $this->authorize('create', ExerciceComptable::class);
        $coproprietes = Copropriete::actif()->orderBy('nom_copropriete')->get();
        return view('admin.exercices.create', compact('coproprietes'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', ExerciceComptable::class);
        $validated = $this->validateExercice($request);
        ExerciceComptable::create($validated);
        return redirect()->route('exercices.index')->with('success', 'Exercice comptable créé avec succès !');
    }

    public function edit(ExerciceComptable $exercice)
    {
        $this->authorize('update', $exercice);
        $coproprietes = Copropriete::orderBy('nom_copropriete')->get();
        return view('admin.exercices.edit', compact('exercice', 'coproprietes'));
    }

    public function update(Request $request, ExerciceComptable $exercice)
    {
        $this->authorize('update', $exercice);
        $validated = $this->validateExercice($request, $exercice);
        $exercice->update($validated);
        return redirect()->route('exercices.index')->with('success', 'Exercice comptable mis à jour avec succès !');
    }

    public function destroy(ExerciceComptable $exercice)
    {
        $this->authorize('delete', $exercice);
        // Ajouter une vérification: ne pas supprimer si des budgets/factures sont liés.
        $exercice->delete();
        return redirect()->route('exercices.index')->with('success', 'Exercice comptable supprimé avec succès !');
    }

    /**
     * Centralise les règles de validation pour les exercices.
     */
    protected function validateExercice(Request $request, ExerciceComptable $exercice = null): array
    {
        $coproprieteId = $request->input('id_copropriete');

        return $request->validate([
            'id_copropriete' => ['required', 'exists:coproprietes,id_copropriete'],
            'libelle' => 'required|string|max:255',
            'date_debut' => [
                'required',
                'date',
                // Règle de non-chevauchement
                Rule::unique('exercices_comptables')->where(function ($query) use ($coproprieteId, $request) {
                    return $query->where('id_copropriete', $coproprieteId)
                        ->where(function ($q) use ($request) {
                            $q->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
                                ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin]);
                        });
                })->ignore($exercice?->id_exercice, 'id_exercice')
            ],
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'statut' => ['required', new Enum(StatutExercice::class)],
        ]);
    }
}
