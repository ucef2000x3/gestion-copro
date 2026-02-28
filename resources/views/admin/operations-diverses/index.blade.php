<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Opérations Diverses') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold leading-6 text-gray-900">{{ __('Opérations Diverses') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Liste des dépenses et recettes diverses.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            @can('create', App\Models\OperationDiverse::class)
                                <a href="{{ route('operations-diverses.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white">Saisir une opération</a>
                            @endcan
                        </div>
                    </div>
                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Date & Libellé</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Copropriété / Catégorie</th>
                            <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Montant</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($operations as $operation)
                            <tr>
                                <td class="py-4 pl-4 pr-3 text-sm sm:pl-0">
                                    <div class="font-medium text-gray-900">{{ $operation->libelle }}</div>
                                    <div class="text-gray-500">{{ $operation->date_operation->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500">
                                    <div class="font-medium text-gray-900">{{ $operation->copropriete->nom_copropriete ?? 'N/A' }}</div>
                                    <div class="text-gray-500">{{ $operation->typeDePoste->libelle ?? 'N/A' }}</div>
                                </td>
                                <td class="px-3 py-4 text-sm text-right font-semibold {{ $operation->type_operation === 'Recette' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $operation->type_operation === 'Recette' ? '+' : '-' }}
                                    {{ number_format($operation->montant, 2, ',', ' ') }} €
                                </td>
                                <td class="relative py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    @can('update', $operation)
                                        <a href="{{ route('operations-diverses.edit', $operation) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4">Aucune opération diverse trouvée.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $operations->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
