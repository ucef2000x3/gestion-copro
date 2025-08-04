<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Residence;
use App\Models\Copropriete;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    /**
     * Affiche la liste des residences.
     */
    public function index()
    {
        $this->authorize('viewAny', Residence::class);

        // Pour l'instant, si l'utilisateur a le droit de voir, on lui montre tout.
        // Le filtrage contextuel sera une optimisation future.
        $residences = \App\Models\Residence::with('copropriete')->latest()->paginate(10);

        return view('admin.residences.index', compact('residences'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle résidence.
     */
    public function create()
    {
        $this->authorize('create', Residence::class);

        // On ne propose que les résidences actives pour la liaison.
        //$coproprietes = Copropriete::where('statut', true)->orderBy('nom_residence')->get();
        // On s'assure de récupérer TOUTES les résidences
        $coproprietes = Copropriete::orderBy('nom_copropriete')->get();

        return view('admin.residences.create', compact('coproprietes'));
    }

    /**
     * Enregistre une nouvelle résidence dans la base de données.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Residence::class);
        $validated = $request->validate([
            'nom_residence' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:10',
            'ville' => 'nullable|string|max:255',
            'id_copropriete' => ['required', 'exists:coproprietes,id_copropriete', function ($attribute, $value, $fail) {
                if (Copropriete::find($value)->statut === false) {
                    $fail(__('Selected Condominium Inactive'));
                }
            }],
            'statut' => 'required|boolean', // <<<--- On ajoute la validation pour le statut
        ]);
        Residence::create($validated);
        return redirect()->route('residences.index')->with('success', __('Residence created successfully!'));
    }

    /**
     * Affiche le formulaire pour modifier une résidence existant.
     */
    public function edit(Residence $residence)
    {
        $this->authorize('update', $residence);

        // Pour le formulaire de modification, on affiche toutes les résidences,
        // et on gère les inactives directement dans la vue.
        $coproprietes = Copropriete::orderBy('nom_copropriete')->get();

        return view('admin.residences.edit', compact('residence', 'coproprietes'));
    }

    /**
     * Met à jour la résidence dans la base de données.
     */
    public function update(Request $request, Residence $residence)
    {
        $this->authorize('update', $residence);
        $validated = $request->validate([
            'nom_residence' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:10',
            'ville' => 'nullable|string|max:255',
            'id_copropriete' => ['required', 'exists:coproprietes,id_copropriete', function ($attribute, $value, $fail) {
                if (Copropriete::find($value)->statut === false) {
                    $fail(__('Selected Condominium Inactive'));
                }
            }],
            'statut' => 'required|boolean', // <<<--- La validation est déjà correcte ici
        ]);
        $residence->update($validated);
        return redirect()->route('residences.index')->with('success', __('Residence updated successfully!'));
    }

    /**
     * Supprime la résidence de la base de données.
     */
    public function destroy(Residence $residence)
    {
        $this->authorize('delete', $residence);

        // Règle de protection : on ne peut pas supprimer une résidence s'il contient encore des lots.
        if ($residence->lots()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette résidence car elle est encore liée à un ou plusieurs lots.');
        }

        $residence->delete();

        return redirect()->route('residences.index')->with('success', __('Residence deleted successfully!'));
    }
}
