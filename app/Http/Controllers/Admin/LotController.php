<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Residence;
use App\Models\Proprietaire;
use App\Models\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
{
    /**
     * Affiche la liste des lots.
     */
    public function index()
    {
        $this->authorize('viewAny', Lot::class);
        $lots = Lot::with('residence')->latest()->paginate(15);
        return view('admin.lots.index', compact('lots'));
    }

    /**
     * Affiche le formulaire de création d'un lot.
     */
    public function create()
    {
        $this->authorize('create', Lot::class);
        // On ne propose que les residences actifs pour la création.
        $residences = Residence::actif()->orderBy('nom_residence')->get();
        return view('admin.lots.create', compact('residences'));
    }

    /**
     * Enregistre un nouveau lot.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Lot::class);

        $validated = $request->validate([
            'numero_lot' => 'required|string|max:255',
            'nombre_tantiemes' => 'required|integer|min:0',
            'id_residence' => ['required', 'exists:residences,id_residence', function ($attribute, $value, $fail) {
                $residence = Residence::find($value);
                if ($residence && !$residence->statut) {
                    $fail(__('Selected Residence Inactive'));
                }
            }],
            'statut' => 'required|boolean',
        ]);

        Lot::create($validated);

        return redirect()->route('lots.index')->with('success', __('Lot created successfully!'));
    }

    /**
     * Affiche le formulaire de modification d'un lot.
     */
    public function edit(Lot $lot)
    {
        $this->authorize('update', $lot);

        // On charge les propriétaires DÉJÀ liés pour un affichage optimisé
        $lot->load('proprietaires');

        // On récupère les données pour les menus déroulants du formulaire principal
        $residences = Residence::orderBy('nom_residence')->get();

        // On récupère uniquement les propriétaires actifs qui ne sont pas DÉJÀ liés à ce lot
        // pour peupler le menu déroulant d'ajout.
        $proprietaires_non_lies = Proprietaire::actif()
            ->whereNotIn('id_proprietaire', $lot->proprietaires->pluck('id_proprietaire'))
            ->orderBy('nom')
            ->get();

        return view('admin.lots.edit', compact('lot', 'residences', 'proprietaires_non_lies'));
    }

    /**
     * Met à jour un lot.
     */
    public function update(Request $request, Lot $lot)
    {
        $this->authorize('update', $lot);

        $validated = $request->validate([
            'numero_lot' => 'required|string|max:255',
            'nombre_tantiemes' => 'required|integer|min:0',
            'id_residence' => ['required', 'exists:residences,id_residence', function ($attribute, $value, $fail) {
                $residence = Residence::find($value);
                if ($residence && !$residence->statut) {
                    $fail(__('Selected Residence Inactive'));
                }
            }],
            'statut' => 'required|boolean',
        ]);

        $lot->update($validated);

        return redirect()->route('lots.index')->with('success', __('Lot updated successfully!'));
    }

    /**
     * Supprime un lot.
     */
    public function destroy(Lot $lot)
    {
        $this->authorize('delete', $lot);
        // On pourrait ajouter une vérification ici (ex: si le lot est lié à un propriétaire)
        $lot->delete();
        return redirect()->route('lots.index')->with('success', __('Lot deleted successfully!'));
    }
}
