<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Affectation;
use Illuminate\Http\Request;

class UserAffectationController extends Controller
{
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'id_role' => 'required|exists:roles,id_role',
            'affectable' => 'required|string',
        ]);

        list($affectable_type, $affectable_id) = explode(':', $validated['affectable']);

        $user->affectations()->create([
            'id_role' => $validated['id_role'],
            'affectable_type' => $affectable_type,
            'affectable_id' => $affectable_id,
        ]);

        return back()->with('success', 'Affectation ajoutée avec succès.');
    }

    public function destroy(User $user, Affectation $affectation)
    {
        // Vérifier que l'affectation appartient bien à l'utilisateur par sécurité
        if ($affectation->id_utilisateur !== $user->id) {
            abort(403);
        }
        $affectation->delete();
        return back()->with('success', 'Affectation retirée avec succès.');
    }
}
