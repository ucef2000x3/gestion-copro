<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Copropriete;
use App\Models\Residence;
use Illuminate\Http\Request;

class CoproprieteController extends Controller
{
    /**
     * Affiche la liste des copropriétés.
     */
    public function index()
    {
        $this->authorize('viewAny', Copropriete::class);

        // Pour l'instant, si l'utilisateur a le droit de voir, on lui montre tout.
        // Le filtrage contextuel sera une optimisation future.
        $coproprietes = Copropriete::with('residence')->latest()->paginate(10);

        return view('admin.coproprietes.index', compact('coproprietes'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle copropriété.
     */
    public function create()
    {
        $this->authorize('create', Copropriete::class);

        // On ne propose que les résidences actives pour la liaison.
        //$residences = Residence::where('statut', true)->orderBy('nom_residence')->get();
        // On s'assure de récupérer TOUTES les résidences
        $residences = Residence::orderBy('nom_residence')->get();

        return view('admin.coproprietes.create', compact('residences'));
    }

    /**
     * Enregistre une nouvelle copropriété dans la base de données.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Copropriete::class);
        $validated = $request->validate([
            'nom_copropriete' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:10',
            'ville' => 'nullable|string|max:255',
            'id_residence' => ['required', 'exists:residences,id_residence', function ($attribute, $value, $fail) {
                if (Residence::find($value)->statut === false) {
                    $fail('La résidence sélectionnée est inactive.');
                }
            }],
            'statut' => 'required|boolean', // <<<--- On ajoute la validation pour le statut
        ]);
        Copropriete::create($validated);
        return redirect()->route('coproprietes.index')->with('success', 'Copropriété créée avec succès !');
    }

    /**
     * Affiche le formulaire pour modifier une copropriété existante.
     */
    public function edit(Copropriete $copropriete)
    {
        $this->authorize('update', $copropriete);

        // Pour le formulaire de modification, on affiche toutes les résidences,
        // et on gère les inactives directement dans la vue.
        $residences = Residence::orderBy('nom_residence')->get();

        return view('admin.coproprietes.edit', compact('copropriete', 'residences'));
    }

    /**
     * Met à jour la copropriété dans la base de données.
     */
    public function update(Request $request, Copropriete $copropriete)
    {
        $this->authorize('update', $copropriete);
        $validated = $request->validate([
            'nom_copropriete' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:10',
            'ville' => 'nullable|string|max:255',
            'id_residence' => ['required', 'exists:residences,id_residence', function ($attribute, $value, $fail) {
                if (Residence::find($value)->statut === false) {
                    $fail('La résidence sélectionnée est inactive.');
                }
            }],
            'statut' => 'required|boolean', // <<<--- La validation est déjà correcte ici
        ]);
        $copropriete->update($validated);
        return redirect()->route('coproprietes.index')->with('success', 'Copropriété mise à jour avec succès !');
    }

    /**
     * Supprime la copropriété de la base de données.
     */
    public function destroy(Copropriete $copropriete)
    {
        $this->authorize('delete', $copropriete);

        // Règle de protection : on ne peut pas supprimer une copropriété si elle contient encore des lots.
        if ($copropriete->lots()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette copropriété car elle est encore liée à un ou plusieurs lots.');
        }

        $copropriete->delete();

        return redirect()->route('coproprietes.index')->with('success', 'Copropriété supprimée avec succès !');
    }
}
