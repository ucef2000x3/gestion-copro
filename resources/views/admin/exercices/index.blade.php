<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exercices Comptables') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold leading-6 text-gray-900">Exercices Comptables</h1>
                            <p class="mt-2 text-sm text-gray-700">Liste des périodes comptables par copropriété.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            @can('create', App\Models\ExerciceComptable::class)
                                <a href="{{ route('exercices.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                    Ajouter un exercice
                                </a>
                            @endcan
                        </div>
                    </div>

                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
                    @if (session('error'))<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">{{ session('error') }}</div>@endif

                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Libellé</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Copropriété</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date de Début</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date de Fin</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($exercices as $exercice)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $exercice->libelle }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $exercice->copropriete->nom_copropriete ?? 'N/A' }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $exercice->date_debut->format('d/m/Y') }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $exercice->date_fin->format('d/m/Y') }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $exercice->statut }}</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <div class="flex items-center justify-end space-x-4">
                                        @can('viewAny', App\Models\BudgetPoste::class) {{-- Adaptez la permission si besoin --}}
                                        <a href="{{ route('exercices.budget.index', $exercice) }}" class="text-blue-600 hover:text-blue-900">Budget</a>
                                        @endcan
                                        @can('create', App\Models\AppelDeFonds::class) {{-- Adaptez la permission si besoin --}}
                                        <a href="{{ route('exercices.appels.create', $exercice) }}" class="text-green-600 hover:text-green-900">Générer Appels</a>
                                        @endcan
                                        @can('update', $exercice)
                                            <a href="{{ route('exercices.edit', $exercice) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                        @endcan
                                        @can('delete', $exercice)
                                            <form action="{{ route('exercices.destroy', $exercice) }}" method="POST" onsubmit="return confirm('Sûr ?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-500">Aucun exercice trouvé.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $exercices->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
