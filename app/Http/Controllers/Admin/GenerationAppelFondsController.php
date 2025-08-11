<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ExerciceComptable;
use App\Models\Lot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenerationAppelFondsController extends Controller
{
    public function create(ExerciceComptable $exercice)
    {
        $exercice->load('copropriete', 'budgetPostes');
        $totalBudget = $exercice->budgetPostes->sum('montant_previsionnel');
        return view('admin.generation-appels.create', compact('exercice', 'totalBudget'));
    }

    public function store(Request $request, ExerciceComptable $exercice)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'date_appel' => 'required|date',
            'date_echeance' => 'required|date|after_or_equal:date_appel',
            'montant_total_a_appeler' => 'required|numeric|min:0',
        ]);

        $copropriete = $exercice->copropriete;
        $lots = $copropriete->lots()->where('lots.statut', true)->get();
        $totalTantiemes = $lots->sum('nombre_tantiemes');

        if ($totalTantiemes == 0) {
            return back()->with('error', 'Aucun tantième défini pour les lots de cette copropriété. Impossible de répartir le montant.');
        }

        $prixParTantieme = $validated['montant_total_a_appeler'] / $totalTantiemes;

        DB::transaction(function () use ($lots, $exercice, $validated, $prixParTantieme) {
            foreach ($lots as $lot) {
                $montantLot = $lot->nombre_tantiemes * $prixParTantieme;
                $exercice->appelsDeFonds()->create([
                    'id_lot' => $lot->id_lot,
                    'libelle' => $validated['libelle'],
                    'montant_appele' => $montantLot,
                    'date_appel' => $validated['date_appel'],
                    'date_echeance' => $validated['date_echeance'],
                ]);
            }
        });

        return redirect()->route('appels-de-fonds.index')->with('success', 'Appels de fonds générés avec succès !');
    }
}
