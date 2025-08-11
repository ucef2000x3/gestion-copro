<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Models\Fournisseur;
use App\Models\Copropriete;
use App\Models\ExerciceComptable;
use Illuminate\Http\Request;
class FactureController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Facture::class);
        $factures = Facture::with('fournisseur', 'copropriete')->latest()->paginate(15);
        return view('admin.factures.index', compact('factures'));
    }

    public function create()
    {
        $this->authorize('create', Facture::class);

        $fournisseurs = Fournisseur::actif()->orderBy('nom')->get();
        //$coproprietes = Copropriete::actif()->orderBy('nom_copropriete')->get();
        $coproprietes = Copropriete::actif()
            ->with(['exercicesComptables' => function ($query) { // <<<--- LE NOM EST ICI
                $query->where('statut', \App\Enums\StatutExercice::Ouvert)
                    ->with('budgetPostes.typeDePoste');
            }])
            ->orderBy('nom_copropriete')
            ->get();

        // Pas besoin de charger les exercices ici.

        return view('admin.factures.create', compact('fournisseurs', 'coproprietes'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Facture::class);
        $validated = $request->validate([
            'id_fournisseur' => 'required|exists:fournisseurs,id_fournisseur',
            'id_copropriete' => 'required|exists:coproprietes,id_copropriete',
            'id_exercice' => 'required|exists:exercices_comptables,id_exercice',
            'id_budget_poste' => 'nullable|exists:budget_postes,id_poste',
            'objet' => 'required|string|max:255',
            'numero_facture' => 'nullable|string|max:255',
            'date_emission' => 'required|date',
            'date_echeance' => 'nullable|date|after_or_equal:date_emission',
            'montant_ttc' => 'required|numeric|min:0',
            'montant_ht' => 'nullable|numeric|min:0',
            'montant_tva' => 'nullable|numeric|min:0',
        ]);
        // On force l'id_syndic en se basant sur la copropriété choisie
        $validated['id_syndic'] = Copropriete::find($validated['id_copropriete'])->id_syndic;
        Facture::create($validated);
        return redirect()->route('factures.index')->with('success', 'Facture créée avec succès.');
    }

    public function edit(Facture $facture)
    {
        $this->authorize('update', $facture);

        $fournisseurs = Fournisseur::orderBy('nom')->get();

        // On charge EXACTEMENT la même structure de données que pour `create`
        $coproprietes = Copropriete::with([
            'exercicesComptables' => function ($query) {
                $query->where('statut', \App\Enums\StatutExercice::Ouvert)
                    ->with('budgetPostes.typeDePoste');
            }
        ])
            ->orderBy('nom_copropriete')->get();

        return view('admin.factures.edit', compact('facture', 'fournisseurs', 'coproprietes'));
    }

    public function update(Request $request, Facture $facture)
    {
        $this->authorize('update', $facture);

        // On ajoute aussi la règle de validation ici
        $validated = $request->validate([
            'id_fournisseur' => 'required|exists:fournisseurs,id_fournisseur',
            'id_copropriete' => 'required|exists:coproprietes,id_copropriete',
            'id_exercice' => 'required|exists:exercices_comptables,id_exercice',
            'id_budget_poste' => 'nullable|exists:budget_postes,id_poste', // <<<--- NOUVELLE RÈGLE
            'objet' => 'required|string|max:255',
            'numero_facture' => 'nullable|string|max:255',
            'date_emission' => 'required|date',
            'date_echeance' => 'nullable|date|after_or_equal:date_emission',
            'montant_ttc' => 'required|numeric|min:0',
        ]);

        $validated['id_syndic'] = Copropriete::find($validated['id_copropriete'])->id_syndic;

        $facture->update($validated);

        return redirect()->route('factures.index')->with('success', __('Invoice updated successfully!'));
    }

    public function destroy(Facture $facture)
    {
        $this->authorize('delete', $facture);
        $facture->delete();
        return redirect()->route('factures.index')->with('success', 'Facture supprimée avec succès.');
    }
}
