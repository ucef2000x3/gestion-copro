<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Residence;
use App\Models\Syndic;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    /**
     * Affiche la liste des résidences.
     */
    public function index()
    {
        // 1. Vérifie si l'utilisateur a la permission générale de voir la liste des résidences.
        $this->authorize('viewAny', Residence::class);

        // 2. Récupère les résidences.
        // Pour l'instant, si un utilisateur a le droit de voir la page, on lui montre tout.
        // Le filtrage fin par périmètre est une optimisation que nous pourrons ajouter plus tard.
        // `with('syndic')` optimise en chargeant les syndics associés en une seule requête.
        $residences = Residence::with('syndic')->latest()->paginate(10);

        // 3. Renvoie la vue avec les données.
        return view('admin.residences.index', compact('residences'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle résidence.
     */
    public function create()
    {
        // 1. Vérifie si l'utilisateur a la permission de créer.
        $this->authorize('create', Residence::class);

        // 2. Récupère tous les syndics pour les afficher dans le menu déroulant du formulaire.
        $syndics = Syndic::orderBy('nom_entreprise')->get();

        // 3. Renvoie la vue du formulaire de création.
        return view('admin.residences.create', compact('syndics'));
    }

    /**
     * Enregistre une nouvelle résidence dans la base de données.
     */
    public function store(Request $request)
    {
        // 1. Vérifie si l'utilisateur a la permission de créer.
        $this->authorize('create', Residence::class);

        // 2. Valide les données envoyées par le formulaire.
        $validated = $request->validate([
            'nom_residence' => 'required|string|max:255',
            'id_syndic' => ['required', 'exists:syndics,id_syndic', function ($attribute, $value, $fail) {
                $syndic = Syndic::find($value);
                // Règle de validation personnalisée : le syndic choisi doit être actif.
                if ($syndic && $syndic->statut === false) {
                    $fail('Le syndic sélectionné est inactif et ne peut pas être assigné.');
                }
            }],
        ]);

        // 3. Crée la résidence.
        // Le champ 'statut' de la résidence aura sa valeur par défaut ('true') définie par la migration.
        Residence::create($validated);

        // 4. Redirige vers la liste avec un message de succès.
        return redirect()->route('residences.index')->with('success', 'Résidence créée avec succès !');
    }

    /**
     * Affiche le formulaire pour modifier une résidence existante.
     */
    public function edit(Residence $residence)
    {
        // 1. Vérifie si l'utilisateur a le droit de modifier CETTE résidence spécifique.
        $this->authorize('update', $residence);

        // 2. Récupère tous les syndics pour le menu déroulant.
        $syndics = Syndic::orderBy('nom_entreprise')->get();

        // 3. Renvoie la vue du formulaire de modification avec les données de la résidence ET la liste des syndics.
        return view('admin.residences.edit', compact('residence', 'syndics'));
    }

    /**
     * Met à jour la résidence dans la base de données.
     */
    public function update(Request $request, Residence $residence)
    {
        // 1. Vérifie si l'utilisateur a le droit de modifier CETTE résidence.
        $this->authorize('update', $residence);

        // 2. Valide les données du formulaire de modification.
        $validated = $request->validate([
            'nom_residence' => 'required|string|max:255',
            'id_syndic' => ['required', 'exists:syndics,id_syndic', function ($attribute, $value, $fail) {
                $syndic = Syndic::find($value);
                if ($syndic && $syndic->statut === false) {
                    $fail('Le syndic sélectionné est inactif et ne peut pas être assigné.');
                }
            }],
            'statut' => 'required|boolean',
            // Note : si vous ajoutez un champ 'statut' au formulaire, il faudra ajouter sa validation ici.
        ]);

        // 3. Met à jour la résidence avec les données validées.
        $residence->update($validated);

        // 4. Redirige vers la liste avec un message de succès.
        return redirect()->route('residences.index')->with('success', 'Résidence mise à jour avec succès !');
    }

    /**
     * Supprime la résidence de la base de données.
     */
    public function destroy(Residence $residence)
    {
        // 1. Vérifie si l'utilisateur a le droit de supprimer CETTE résidence.
        $this->authorize('delete', $residence);

        // 2. Supprime la résidence.
        $residence->delete();

        // 3. Redirige vers la liste avec un message de succès.
        return redirect()->route('residences.index')->with('success', 'Résidence supprimée avec succès !');
    }
}
