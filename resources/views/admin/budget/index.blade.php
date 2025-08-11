<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion du Budget - {{ $exercice->libelle }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- INFOS DE L'EXERCICE -->
            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-medium text-gray-900">Exercice Comptable</h3>
                <p class="text-sm text-gray-500">
                    Copropriété: <span class="font-semibold">{{ $exercice->copropriete->nom_copropriete }}</span> |
                    Période: <span class="font-semibold">{{ $exercice->date_debut->format('d/m/Y') }}</span> au <span class="font-semibold">{{ $exercice->date_fin->format('d/m/Y') }}</span> |
                    Statut: <span class="font-semibold">{{ $exercice->statut }}</span>
                </p>
            </div>

            <!-- GESTION DU BUDGET -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif

                    <!-- Tableau des postes déjà au budget -->
                    <h2 class="text-xl font-semibold mb-4">Budget Prévisionnel</h2>
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Poste Budgétaire</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Code Comptable</th>
                            <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Montant Prévisionnel</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse ($exercice->budgetPostes as $poste)
                            <tr>
                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $poste->typeDePoste->libelle }}</td>
                                <td class="px-3 py-4 text-sm text-gray-500 font-mono">{{ $poste->typeDePoste->code_comptable }}</td>
                                <td class="px-3 py-4 text-sm text-gray-900 text-right font-semibold">{{ number_format($poste->montant_previsionnel, 2, ',', ' ') }} €</td>
                                <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <form action="{{ route('budget-postes.destroy', $poste) }}" method="POST" onsubmit="return confirm('Sûr ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Retirer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4">Aucun poste dans ce budget.</td></tr>
                        @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                        <tr>
                            <th colspan="2" class="py-3.5 pl-4 pr-3 text-right text-sm font-bold text-gray-900 sm:pl-0">TOTAL PRÉVISIONNEL</th>
                            <td class="px-3 py-3.5 text-right text-sm font-bold text-gray-900">{{ number_format($exercice->budgetPostes->sum('montant_previsionnel'), 2, ',', ' ') }} €</td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>

                    <!-- Formulaire pour ajouter un nouveau poste -->
                    <div class="mt-8 border-t pt-8">
                        <h3 class="text-lg font-medium text-gray-900">Ajouter un poste au budget</h3>
                        <form action="{{ route('exercices.budget.store', $exercice) }}" method="POST" class="mt-4 grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                            @csrf
                            <div class="col-span-2">
                                <label for="id_type_poste" class="block text-sm font-medium">Choisir un type de poste</label>
                                <select name="id_type_poste" id="id_type_poste" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                    <option value="">-- Postes disponibles --</option>
                                    @foreach ($availablePostes as $posteDispo)
                                        <option value="{{ $posteDispo->id_type_poste }}">{{ $posteDispo->libelle }}</option>
                                    @endforeach
                                </select>
                                @error('id_type_poste')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="montant_previsionnel" class="block text-sm font-medium">Montant Prévisionnel (€)</label>
                                <input type="number" step="0.01" min="0" name="montant_previsionnel" id="montant_previsionnel" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                @error('montant_previsionnel')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <x-primary-button type="submit">{{ __('Ajouter') }}</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
