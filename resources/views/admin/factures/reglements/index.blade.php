<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Règlements de la Facture :') }} {{ $facture->objet }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Résumé Financier -->
            @php
                $totalRegle = $facture->reglements->sum('montant_regle');
                $soldeDu = $facture->montant_ttc - $totalRegle;
            @endphp
            <div class="mb-6 grid grid-cols-1 gap-5 sm:grid-cols-4">
                <div class="bg-white overflow-hidden shadow rounded-lg p-5"><dt class="text-sm font-medium text-gray-500 truncate">Copropriété</dt><dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">{{ $facture->copropriete->nom_copropriete }}</dd></div>
                <div class="bg-white overflow-hidden shadow rounded-lg p-5"><dt class="text-sm font-medium text-gray-500 truncate">Montant TTC</dt><dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">{{ number_format($facture->montant_ttc, 2, ',', ' ') }} €</dd></div>
                <div class="bg-white overflow-hidden shadow rounded-lg p-5"><dt class="text-sm font-medium text-gray-500 truncate">Total Réglé</dt><dd class="mt-1 text-2xl font-semibold tracking-tight text-green-600">{{ number_format($totalRegle, 2, ',', ' ') }} €</dd></div>
                <div class="bg-white overflow-hidden shadow rounded-lg p-5"><dt class="text-sm font-medium text-gray-500 truncate">Solde Dû</dt><dd class="mt-1 text-2xl font-semibold tracking-tight text-red-600">{{ number_format($soldeDu, 2, ',', ' ') }} €</dd></div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
                    @if ($errors->any())<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

                    <!-- Formulaire pour AJOUTER un règlement -->
                    @if($soldeDu > 0.001)
                        <div class="border-b pb-8">
                            <h3 class="text-lg font-medium text-gray-900">Enregistrer un nouveau règlement</h3>
                            <form action="{{ route('factures.reglements.store', $facture) }}" method="POST" class="mt-4 grid grid-cols-1 sm:grid-cols-5 gap-4 items-end">
                                @csrf
                                <div class="sm:col-span-2"><label for="montant_regle" class="block text-sm">Montant</label><input type="number" step="0.01" max="{{ $soldeDu }}" name="montant_regle" id="montant_regle" required class="mt-1 block w-full rounded-md text-sm"></div>
                                <div><label for="date_reglement" class="block text-sm">Date</label><input type="date" name="date_reglement" id="date_reglement" value="{{ now()->format('Y-m-d') }}" required class="mt-1 block w-full rounded-md text-sm"></div>
                                <div><label for="mode_de_reglement" class="block text-sm">Mode</label><select name="mode_de_reglement" id="mode_de_reglement" required class="mt-1 block w-full rounded-md text-sm"><option>Virement</option><option>Chèque</option></select></div>
                                <x-primary-button type="submit">{{ __('Payer') }}</x-primary-button>
                            </form>
                        </div>
                    @else
                        <div class="p-4 text-sm text-center text-green-800 bg-green-100 rounded-lg">Cette facture est entièrement soldée.</div>
                    @endif

                    <!-- Liste des règlements EXISTANTS -->
                    <div class="mt-6">
                        <h3 class="font-medium text-gray-800 mb-2">Historique des règlements</h3>
                        <ul role="list" class="divide-y divide-gray-200 border rounded-md">
                            @forelse($facture->reglements as $reglement)
                                <li class="px-4 py-3 flex justify-between items-center">
                                    <div>
                                        <span class="font-bold">{{ number_format($reglement->montant_regle, 2, ',', ' ') }} €</span>
                                        <span class="text-gray-600 ml-4">le {{ $reglement->date_reglement->format('d/m/Y') }} par {{ $reglement->mode_de_reglement }}</span>
                                    </div>
                                    <form action="{{ route('factures.reglements.destroy', $reglement) }}" method="POST" onsubmit="return confirm('Sûr ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Annuler</button>
                                    </form>
                                </li>
                            @empty
                                <li class="px-4 py-3 text-sm text-gray-500">Aucun règlement enregistré pour cette facture.</li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
