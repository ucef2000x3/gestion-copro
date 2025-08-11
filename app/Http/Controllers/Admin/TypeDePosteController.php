<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Copropriete;
use App\Models\TypeDePoste;
use Illuminate\Http\Request;
class TypeDePosteController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', TypeDePoste::class);
        $typesDePoste = TypeDePoste::with('copropriete')->latest()->paginate(15);
        return view('admin.types-de-poste.index', compact('typesDePoste'));
    }
    public function create()
    {
        $this->authorize('create', TypeDePoste::class);
        $coproprietes = Copropriete::actif()->orderBy('nom_copropriete')->get();
        return view('admin.types-de-poste.create', compact('coproprietes'));
    }
    public function store(Request $request)
    {
        $this->authorize('create', TypeDePoste::class);
        $validated = $request->validate([
            'id_copropriete' => 'required|exists:coproprietes,id_copropriete',
            'libelle' => 'required|string|max:255',
            'code_comptable' => 'nullable|string|max:255',
            'statut' => 'required|boolean',
        ]);
        TypeDePoste::create($validated);
        return redirect()->route('types-de-poste.index')->with('success', 'Poste créé avec succès.');
    }
    public function edit(TypeDePoste $typeDePoste)
    {
        $this->authorize('update', $typeDePoste);
        $coproprietes = Copropriete::orderBy('nom_copropriete')->get();
        return view('admin.types-de-poste.edit', compact('typeDePoste', 'coproprietes'));
    }
    public function update(Request $request, TypeDePoste $typeDePoste)
    {
        $this->authorize('update', $typeDePoste);
        $validated = $request->validate([
            'id_copropriete' => 'required|exists:coproprietes,id_copropriete',
            'libelle' => 'required|string|max:255',
            'code_comptable' => 'nullable|string|max:255',
            'statut' => 'required|boolean',
        ]);
        $typeDePoste->update($validated);
        return redirect()->route('types-de-poste.index')->with('success', 'Poste mis à jour avec succès.');
    }
    public function destroy(TypeDePoste $typeDePoste)
    {
        $this->authorize('delete', $typeDePoste);
        // On pourrait vérifier s'il est utilisé dans un budget avant de supprimer.
        $typeDePoste->delete();
        return redirect()->route('types-de-poste.index')->with('success', 'Poste supprimé avec succès.');
    }
}
