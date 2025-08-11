<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FactureImputationController extends Controller
{
    public function store(Request $request, Facture $facture)
    {
        $this->authorize('update', $facture);

        $validated = $request->validate([
            'imputations' => 'required|array',
            'imputations.*.montant' => 'required|numeric|min:0',
            'imputations.*.id_poste' => 'required|exists:budget_postes,id_poste',
        ]);

        // On filtre pour ne garder que les montants non nuls
        $imputations = Arr::where($validated['imputations'], fn ($value) => $value['montant'] > 0);

        // Vérifier que le total imputé ne dépasse pas le montant de la facture
        $totalImpute = collect($imputations)->sum('montant');
        if ($totalImpute > $facture->montant_ttc) {
            return back()->with('error', 'Le total imputé ('.$totalImpute.'€) ne peut pas dépasser le montant de la facture ('.$facture->montant_ttc.'€).');
        }

        // Préparer les données pour la synchronisation
        $syncData = collect($imputations)->mapWithKeys(function ($item) {
            return [$item['id_poste'] => ['montant_impute' => $item['montant']]];
        });

        // sync() est la méthode magique pour les tables pivot
        $facture->budgetPostes()->sync($syncData);

        return back()->with('success', 'Imputation budgétaire enregistrée avec succès.');
    }
}
