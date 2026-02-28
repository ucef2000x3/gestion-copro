<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Models\ReglementFacture;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FactureReglementController extends Controller
{
    /**
     * Affiche la page de gestion des règlements pour une facture.
     */
    public function index(Facture $facture)
    {
        // On vérifie si l'utilisateur a le droit de "payer" (ou de gérer les paiements) pour cette facture.
        $this->authorize('payer', $facture);

        // On charge la facture avec ses règlements existants pour les afficher.
        $facture->load('reglements');

        return view('admin.factures.reglements.index', compact('facture'));
    }

    /**
     * Enregistre un nouveau règlement pour une facture.
     */
    public function store(Request $request, Facture $facture)
    {
        $this->authorize('payer', $facture);

        $validated = $request->validate([
            'montant_regle' => 'required|numeric|min:0.01',
            'date_reglement' => 'required|date',
            'mode_de_reglement' => 'required|string|max:255',
            'reference_reglement' => 'nullable|string|max:255',
        ]);

        // Règle de gestion : on ne peut pas payer plus que le solde dû.
        $soldeDu = $facture->montant_ttc - $facture->reglements()->sum('montant_regle');
        if ($validated['montant_regle'] > $soldeDu + 0.001) { // Tolérance pour les erreurs d'arrondi
            throw ValidationException::withMessages(['montant_regle' => 'Le montant réglé ne peut pas dépasser le solde dû de ' . number_format($soldeDu, 2, ',', ' ') . ' €.']);
        }

        $validated['id_exercice'] = $facture->id_exercice;
        $facture->reglements()->create($validated);

        $this->updateStatutFacture($facture);

        return back()->with('success', 'Règlement enregistré avec succès.');
    }

    /**
     * Supprime un règlement.
     */
    public function destroy(ReglementFacture $reglement)
    {
        $facture = $reglement->facture;
        $this->authorize('payer', $facture);

        $reglement->delete();

        $this->updateStatutFacture($facture);

        return back()->with('success', 'Règlement supprimé avec succès.');
    }

    /**
     * Met à jour le statut de la facture en fonction des règlements.
     */
    protected function updateStatutFacture(Facture $facture)
    {
        $totalRegle = $facture->reglements()->sum('montant_regle');
        $nouveauStatut = 'Validée'; // Supposons que la facture est déjà validée à ce stade.

        if ($totalRegle > 0) {
            if (abs($totalRegle - $facture->montant_ttc) < 0.01) { // Comparaison de floats
                $nouveauStatut = 'Payée';
            } else {
                $nouveauStatut = 'Partiellement payée';
            }
        }

        $facture->update(['statut' => $nouveauStatut]);
    }
}
