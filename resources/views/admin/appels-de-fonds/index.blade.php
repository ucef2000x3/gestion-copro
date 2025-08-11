<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Liste des Appels de Fonds') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold leading-6 text-gray-900">Appels de Fonds</h1>
                            <p class="mt-2 text-sm text-gray-700">Liste de tous les appels de fonds générés.</p>
                        </div>
                    </div>

                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif

                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Libellé</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Lot / Copropriété</th>
                            <th class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Montant Appelé</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date Appel</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Échéance</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($appels as $appel)
                            <tr>
                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $appel->libelle }}</td>
                                <td class="px-3 py-4 text-sm text-gray-500">
                                    <div class="font-medium text-gray-900">Lot {{ $appel->lot->numero_lot }}</div>
                                    <div class="text-gray-500">{{ $appel->lot->copropriete->nom_copropriete ?? 'N/A' }}</div>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-900 text-right font-semibold">{{ number_format($appel->montant_appele, 2, ',', ' ') }} €</td>
                                <td class="px-3 py-4 text-sm text-gray-500">{{ $appel->date_appel->format('d/m/Y') }}</td>
                                <td class="px-3 py-4 text-sm text-gray-500">{{ $appel->date_echeance->format('d/m/Y') }}</td>
                                <td class="px-3 py-4 text-sm text-gray-500">{{ $appel->statut }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4">Aucun appel de fonds trouvé.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $appels->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
