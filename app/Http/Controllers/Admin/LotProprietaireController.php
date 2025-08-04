<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lot;
use App\Models\Proprietaire;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LotProprietaireController extends Controller
{
    /**
     * Ajoute un propriétaire à un lot (crée une entrée dans la table pivot).
     */
    public function store(Request $request, Lot $lot)
    {
        $this->authorize('update', $lot); // Seuls ceux qui peuvent modifier un lot peuvent lui ajouter des propriétaires.

        $validated = $request->validate([
            'id_proprietaire' => 'required|exists:proprietaires,id_proprietaire',
            'pourcentage_possession' => 'required|numeric|min:0.01|max:100',
        ]);

        // Règle de gestion : la somme des pourcentages ne doit pas dépasser 100.
        $sommeExistante = $lot->proprietaires()->sum('pourcentage_possession');
        $nouveauTotal = $sommeExistante + $validated['pourcentage_possession'];

        if ($nouveauTotal > 100) {
            // Renvoie une erreur de validation spécifique.
            throw ValidationException::withMessages([
                'pourcentage_possession' => 'L\'ajout de ce pourcentage (' . $validated['pourcentage_possession'] . '%) dépasserait 100%. Le total actuel est de ' . $sommeExistante . '%.',
            ]);
        }

        // `attach` est la méthode pour insérer dans une table pivot `belongsToMany`.
        $lot->proprietaires()->attach($validated['id_proprietaire'], [
            'pourcentage_possession' => $validated['pourcentage_possession']
        ]);

        return back()->with('success', 'Propriétaire ajouté au lot avec succès.');
    }

    /**
     * Met à jour le pourcentage de possession d'un propriétaire sur un lot.
     */
    public function update(Request $request, Lot $lot, Proprietaire $proprietaire)
    {
        $this->authorize('update', $lot);

        $validated = $request->validate([
            'pourcentage_possession' => 'required|numeric|min:0.01|max:100',
        ]);

        // Règle de gestion : la nouvelle somme ne doit pas dépasser 100.
        $sommeAutres = $lot->proprietaires()
            ->where('proprietaires.id_proprietaire', '!=', $proprietaire->id_proprietaire)
            ->sum('pourcentage_possession');

        $nouveauTotal = $sommeAutres + $validated['pourcentage_possession'];

        if ($nouveauTotal > 100) {
            throw ValidationException::withMessages([
                'pourcentage_possession' => 'La modification de ce pourcentage (' . $validated['pourcentage_possession'] . '%) dépasserait 100%. Le total des autres propriétaires est de ' . $sommeAutres . '%.',
            ]);
        }

        // `updateExistingPivot` met à jour une colonne supplémentaire dans la table pivot.
        $lot->proprietaires()->updateExistingPivot($proprietaire->id_proprietaire, [
            'pourcentage_possession' => $validated['pourcentage_possession']
        ]);

        return back()->with('success', 'Pourcentage mis à jour avec succès.');
    }

    /**
     * Retire un propriétaire d'un lot (supprime l'entrée dans la table pivot).
     */
    public function destroy(Lot $lot, Proprietaire $proprietaire)
    {
        $this->authorize('update', $lot);

        // `detach` est la méthode pour supprimer de la table pivot.
        $lot->proprietaires()->detach($proprietaire->id_proprietaire);

        return back()->with('success', 'Propriétaire retiré du lot avec succès.');
    }
}
