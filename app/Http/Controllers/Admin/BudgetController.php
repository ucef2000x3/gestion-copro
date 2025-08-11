<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BudgetPoste;
use App\Models\ExerciceComptable;
use App\Models\TypeDePoste;
use Illuminate\Http\Request;
class BudgetController extends Controller
{
    public function index(ExerciceComptable $exercice)
    {
        // On pourrait créer une BudgetPolicy plus tard
        $this->authorize('update', $exercice);
        $exercice->load('budgetPostes.typeDePoste', 'copropriete');
        $usedPosteIds = $exercice->budgetPostes->pluck('id_type_poste');
        $availablePostes = TypeDePoste::where('id_copropriete', $exercice->id_copropriete)
            ->where('statut', true)
            ->whereNotIn('id_type_poste', $usedPosteIds)
            ->orderBy('libelle')
            ->get();
        return view('admin.budget.index', compact('exercice', 'availablePostes'));
    }

    public function store(Request $request, ExerciceComptable $exercice)
    {
        $this->authorize('update', $exercice);
        $validated = $request->validate([
            'id_type_poste' => 'required|exists:types_de_poste,id_type_poste',
            'montant_previsionnel' => 'required|numeric|min:0',
        ]);
        $exercice->budgetPostes()->create($validated);
        return back()->with('success', 'Poste ajouté au budget avec succès.');
    }

    public function destroy(BudgetPoste $poste)
    {
        $this->authorize('update', $poste->exerciceComptable);
        $exerciceId = $poste->id_exercice;
        $poste->delete();
        return redirect()->route('exercices.budget.index', $exerciceId)->with('success', 'Poste supprimé du budget.');
    }
}
