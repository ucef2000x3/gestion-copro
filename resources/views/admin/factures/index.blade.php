<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Factures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold leading-6 text-gray-900">Factures</h1>
                            <p class="mt-2 text-sm text-gray-700">Liste des factures des fournisseurs.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            @can('create', App\Models\Facture::class)
                                <a href="{{ route('factures.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                    Ajouter une facture
                                </a>
                            @endcan
                        </div>
                    </div>

                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif

                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Objet / N° Facture</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Fournisseur</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Copropriété</th>
                            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Montant TTC</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date Émission</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($factures as $facture)
                            <tr>
                                <td class="py-4 pl-4 pr-3 text-sm sm:pl-0">
                                    <div class="font-medium text-gray-900">{{ $facture->objet }}</div>
                                    <div class="text-gray-500">{{ $facture->numero_facture }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $facture->fournisseur->nom ?? 'N/A' }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $facture->copropriete->nom_copropriete ?? 'N/A' }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 text-right font-semibold">{{ number_format($facture->montant_ttc, 2, ',', ' ') }} {{ $facture->copropriete->devise->symbole ?? '' }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $facture->date_emission->format('d/m/Y') }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $facture->statut }}</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    @can('update', $facture)
                                        <a href="{{ route('factures.edit', $facture) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4">Aucune facture trouvée.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $factures->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
