<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Copropriete;
use App\Models\Residence;
use App\Models\Syndic;
use Illuminate\Http\Request;

class CoproprieteController extends Controller
{
    /**
     * Affiche la liste des copropriétés.
     */
    public function index()
    {
        // 1. Vérifie si l'utilisateur a la permission générale de voir la liste des copropriétés.
        $this->authorize('viewAny', Copropriete::class);

        // 2. Récupère les copropriétés.
        // Pour l'instant, si un utilisateur a le droit de voir la page, on lui montre tout.
        // Le filtrage fin par périmètre est une optimisation que nous pourrons ajouter plus tard.
        // `with('syndic')` optimise en chargeant les syndics associés en une seule requête.
        $coproprietes = Copropriete::with('syndic')->latest()->paginate(10);

        // 3. Renvoie la vue avec les données.
        return view('admin.coproprietes.index', compact('coproprietes'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle copropriété.
     */
    public function create()
    {
        //dd('JE SUIS BIEN DANS LA MÉTHODE CREATE DU COPROPRIETECONTROLLER');
        // 1. On vérifie que l'utilisateur a le droit de créer une copropriété.
        $this->authorize('create', Copropriete::class);

        // CORRECTION : Pour créer une copropriété, on a besoin de la liste des syndics.
        $syndics = Syndic::actif()->orderBy('nom_entreprise')->get();

        // 3. On renvoie la vue de création en lui passant UNIQUEMENT la variable `$residences`.
        return view('admin.coproprietes.create', compact('syndics'));
    }

    /**
     * Enregistre une nouvelle copropriété dans la base de données.
     */
    public function store(Request $request)
    {
        // 1. Vérifie si l'utilisateur a la permission de créer.
        $this->authorize('create', Copropriete::class);

        // 2. Valide les données envoyées par le formulaire.
        $validated = $request->validate([
            'nom_copropriete' => 'required|string|max:255',
            'id_syndic' => ['required', 'exists:syndics,id_syndic', function ($attribute, $value, $fail) {
                $syndic = Syndic::find($value);
                // Règle de validation personnalisée : le syndic choisi doit être actif.
                if ($syndic && $syndic->statut === false) {
                    $fail(__('Syndic Inactive Cannot Assigned'));
                }
            }],
        ]);

        // 3. Crée la copropriété.
        // Le champ 'statut' de la copropriété aura sa valeur par défaut ('true') définie par la migration.
        Copropriete::create($validated);

        // 4. Redirige vers la liste avec un message de succès.
        return redirect()->route('coproprietes.index')->with('success', __('Condominium created successfully!'));
    }

    /**
     * Affiche le formulaire pour modifier une copropriétés existante.
     */
    public function edit(Copropriete $copropriete)
    {
        // 1. Vérifie si l'utilisateur a le droit de modifier CETTE copropriété spécifique.
        $this->authorize('update', $copropriete);

        // 2. Récupère tous les syndics pour le menu déroulant.
        $syndics = Syndic::orderBy('nom_entreprise')->get();

        // 3. Renvoie la vue du formulaire de modification avec les données de la copropriété ET la liste des syndics.
        return view('admin.coproprietes.edit', compact('copropriete', 'syndics'));
    }

    /**
     * Met à jour la copropriété dans la base de données.
     */
    public function update(Request $request, Copropriete $copropriete)
    {
        // 1. Vérifie si l'utilisateur a le droit de modifier CETTE copropriété.
        $this->authorize('update', $copropriete);

        // 2. Valide les données du formulaire de modification.
        $validated = $request->validate([
            'nom_copropriete' => 'required|string|max:255',
            'id_syndic' => ['required', 'exists:syndics,id_syndic', function ($attribute, $value, $fail) {
                $syndic = Syndic::find($value);
                if ($syndic && $syndic->statut === false) {
                    $fail(__('Syndic Inactive Cannot Assigned'));
                }
            }],
            'statut' => 'required|boolean',
            // Note : si vous ajoutez un champ 'statut' au formulaire, il faudra ajouter sa validation ici.
        ]);

        // 3. Met à jour la copropriété avec les données validées.
        $copropriete->update($validated);

        // 4. Redirige vers la liste avec un message de succès.
        return redirect()->route('coproprietes.index')->with('success', __('Condominium updated successfully!'));
    }

    /**
     * Supprime la copropriété de la base de données.
     */
    public function destroy(Copropriete $copropriete)
    {
        // 1. Vérifie si l'utilisateur a le droit de supprimer CETTE copropriété.
        $this->authorize('delete', $copropriete);

        // 2. Supprime la copropriété.
        $copropriete->delete();

        // 3. Redirige vers la liste avec un message de succès.
        return redirect()->route('coproprietes.index')->with('success', __('Condominium deleted successfully!'));
    }
}
