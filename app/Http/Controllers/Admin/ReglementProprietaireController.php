<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReglementProprietaire;
use App\Models\Proprietaire;
use App\Models\Exercice;
use App\Enums\StatutExercice;
use Illuminate\Http\Request;

class ReglementProprietaireController extends Controller
{
    /**
     * Affiche la liste des règlements.
     */
    public function index()
    {
        $this->authorize('viewAny', ReglementProprietaire::class);

        $reglements = ReglementProprietaire::with('proprietaire', 'exercice.copropriete')
            ->latest('date_reglement')
            ->paginate(15);

        return view('admin.reglements-proprietaires.index', compact('reglements'));
    }

    /**
     * Affiche le formulaire de création d'un règlement.
     */
    public function create()
    {
        $this->authorize('create', ReglementProprietaire::class);

        $proprietaires = Proprietaire::actif()->orderBy('nom')->get();
        // On ne peut imputer un règlement que sur un exercice non clôturé.
        $exercices = Exercice::where('statut', '!=', StatutExercice::Cloture)->orderBy('date_debut', 'desc')->get();

        return view('admin.reglements-proprietaires.create', compact('proprietaires', 'exercices'));
    }

    /**
     * Enregistre un nouveau règlement.
     */
    public function store(Request $request)
    {
        $this->authorize('create', ReglementProprietaire::class);

        $validated = $request->validate([
            'id_proprietaire' => 'required|exists:proprietaires,id_proprietaire',
            'id_exercice' => 'required|exists:exercices,id_exercice',
            'montant_regle' => 'required|numeric|min:0.01',
            'date_reglement' => 'required|date',
            'mode_de_reglement' => 'required|string|max:255',
            'reference_paiement' => 'nullable|string|max:255',
        ]);

        ReglementProprietaire::create($validated);

        // Plus tard, cette action déclenchera une écriture dans le journal de trésorerie.

        return redirect()->route('reglements-proprietaires.index')->with('success', 'Règlement enregistré avec succès.');
    }

    // Pour l'instant, nous n'implémentons pas edit/update/destroy car un règlement
    // enregistré ne devrait en principe pas être modifié, mais plutôt contre-passé.
    // On peut les ajouter plus tard si le besoin métier se confirme.
}
