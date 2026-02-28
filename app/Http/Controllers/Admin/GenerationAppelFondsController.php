<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Exercice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GenerationAppelFondsController extends Controller
{
    /**
     * Affiche le formulaire pour lancer la génération des appels de fonds pour un exercice.
     */
    public function create(Exercice $exercice)
    {
        $this->authorize('update', $exercice);

        $exercice->load('copropriete', 'budgetPostes');
        $totalBudget = $exercice->budgetPostes->sum('montant_previsionnel');

        return view('admin.generation-appels.create', compact('exercice', 'totalBudget'));
    }

    /**
     * Traite le formulaire et génère les appels de fonds et leurs détails ventilés.
     */
    public function store(Request $request, Exercice $exercice)
    {
        $this->authorize('update', $exercice);

        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'date_appel' => 'required|date',
            'date_echeance' => 'required|date|after_or_equal:date_appel',
            'montant_total_a_appeler' => 'required|numeric|min:0.01',
        ]);

        $copropriete = $exercice->copropriete;
        $lots = $copropriete->lots()->with('proprietaires')->where('lots.statut', true)->get();
        $totalTantiemes = $lots->sum('nombre_tantiemes');

        if ($totalTantiemes == 0) {
            return back()->with('error', 'Aucun tantième défini pour les lots actifs de cette copropriété. Impossible de répartir le montant.');
        }

        $prixParTantieme = $validated['montant_total_a_appeler'] / $totalTantiemes;

        DB::transaction(function () use ($lots, $exercice, $validated, $prixParTantieme) {
            foreach ($lots as $lot) {
                if ($lot->proprietaires->isEmpty()) {
                    continue;
                }

                $totalPourcentageLot = $lot->proprietaires->sum('pivot.pourcentage_possession');
                if (abs($totalPourcentageLot - 100) > 0.01) {
                    throw ValidationException::withMessages([
                        'lot_'. $lot->id_lot => 'La somme des pourcentages de possession pour le lot N°' . $lot->numero_lot . ' n\'est pas égale à 100% (total actuel : '.$totalPourcentageLot.'%).'
                    ]);
                }

                $montantTotalLot = round($lot->nombre_tantiemes * $prixParTantieme, 2);

                $appelDeFonds = $exercice->appelsDeFonds()->create([
                    'id_lot' => $lot->id_lot,
                    'libelle' => $validated['libelle'],
                    'montant_total_lot' => $montantTotalLot,
                    'date_appel' => $validated['date_appel'],
                    'date_echeance' => $validated['date_echeance'],
                    'statut' => 'En attente',
                ]);

                foreach ($lot->proprietaires as $proprietaire) {
                    $pourcentage = $proprietaire->pivot->pourcentage_possession;
                    $montantQuotePart = round(($montantTotalLot * $pourcentage) / 100, 2);

                    $appelDeFonds->details()->create([
                        'id_proprietaire' => $proprietaire->id_proprietaire,
                        'montant_quote_part' => $montantQuotePart,
                    ]);
                }
            }
        });

        return redirect()->route('appels-de-fonds.index')->with('success', 'Appels de fonds générés avec succès !');
    }
}
