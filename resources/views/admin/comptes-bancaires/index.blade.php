<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Comptes Bancaires & Caisses') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold leading-6 text-gray-900">{{ __('Comptes & Caisses') }}</h1>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            @can('create', App\Models\CompteBancaire::class)
                                <a href="{{ route('comptes-bancaires.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white">Ajouter un Compte/Caisse</a>
                            @endcan
                        </div>
                    </div>
                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Nom du Compte</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Copropriété</th>
                            <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Solde Initial</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($comptes as $compte)
                            <tr>
                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $compte->nom_compte }}</td>
                                <td class="px-3 py-4 text-sm text-gray-500">{{ ucfirst($compte->type_compte) }}</td>
                                <td class="px-3 py-4 text-sm text-gray-500">{{ $compte->copropriete->nom_copropriete ?? 'N/A' }}</td>
                                <td class="px-3 py-4 text-sm text-gray-900 text-right">{{ number_format($compte->solde_initial, 2, ',', ' ') }} €</td>
                                <td class="px-3 py-4 text-sm text-gray-500">
                                    @if($compte->isActif())
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Actif</span>
                                    @else
                                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Inactif</span>
                                    @endif
                                </td>
                                <td class="relative py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <div class="flex items-center justify-end space-x-4">
                                        @can('update', $compte)
                                            <a href="{{ route('comptes-bancaires.edit', $compte) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4">Aucun compte trouvé.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $comptes->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
