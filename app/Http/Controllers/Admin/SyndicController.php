<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Syndic;
use App\Models\Copropriete;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SyndicController extends Controller
{
    public function index()
    {
        // La vérification de la Policy est toujours la première chose à faire.
        // Notre Gate::before() s'en occupera pour le Super Admin.
        $this->authorize('viewAny', Syndic::class);

        $user = auth()->user();

        // On prépare la requête de base
        $query = Syndic::query();

        // =========================================================
        // == NOUVELLE LOGIQUE SIMPLIFIÉE ==
        // =========================================================

        // Si l'utilisateur n'est PAS un Super Admin, alors on applique les filtres.
        if (!$user->isSuperAdmin()) {

            // On récupère les IDs des syndics sur lesquels l'utilisateur
            // a une affectation directe qui lui donne le droit de voir.
            $allowedSyndicIds = $user->affectations()
                ->with('role.permissions')
                ->get()
                ->filter(function ($affectation) {
                    return $affectation->affectable_type === Syndic::class
                        && $affectation->role->permissions->contains('cle', 'syndic:voir');
                })
                ->pluck('affectable_id');

            // On récupère aussi les syndics liés aux résidences sur lesquelles il a un droit
            $coproprietes = $user->affectations()
                ->with('role.permissions')
                ->where('affectable_type', \App\Models\Copropriete::class)
                ->get()
                ->filter(fn($affectation) => $affectation->role->permissions->contains('cle', 'syndic:voir')) // ou residence:voir ?
                ->pluck('affectable_id');
            $allowedSyndicIdsFromCoproprietes = \App\Models\Copropriete::whereIn('id_copropriete', $coproprietes)->pluck('id_syndic');


            // On fusionne les IDs autorisés.
            $finalAllowedIds = $allowedSyndicIds->merge($allowedSyndicIdsFromCoproprietes)->unique();

            // On applique le filtre à la requête
            $query->whereIn('id_syndic', $finalAllowedIds);
        }

        // Si l'utilisateur EST un Super Admin, aucun filtre n'est appliqué
        // et la requête $query récupérera tous les syndics.

        $syndics = $query->latest()->paginate(10);

        return view('admin.syndics.index', compact('syndics'));
    }

    public function create()
    {
        $this->authorize('create', Syndic::class);
        return view('admin.syndics.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Syndic::class);
        $validated = $request->validate([
            'nom_entreprise' => 'required|string|max:255|unique:syndics',
            'statut' => 'required|boolean',
        ]);
        Syndic::create($validated);
        return redirect()->route('syndics.index')->with('success',__('Syndic created successfully!'));
    }

    public function edit(Syndic $syndic)
    {
        $this->authorize('update', $syndic);
        return view('admin.syndics.edit', compact('syndic'));
    }

    public function update(Request $request, Syndic $syndic)
    {
        $this->authorize('update', $syndic);
        $validated = $request->validate([
            'nom_entreprise' => 'required|string|max:255|unique:syndics,nom_entreprise,'.$syndic->id_syndic.',id_syndic',
            'statut' => 'required|boolean',
        ]);
        $syndic->update($validated);
        return redirect()->route('syndics.index')->with('success', __('Syndic updated successfully!'));
    }

    public function destroy(Syndic $syndic)
    {
        $this->authorize('delete', $syndic);

        if ($syndic->coproprietes()->exists()) {
            return back()->with('error', __('Cannot Delete Syndic'));
        }

        $syndic->delete();
        return redirect()->route('syndics.index')->with('success', __('Syndic deleted successfully!'));
    }
}
