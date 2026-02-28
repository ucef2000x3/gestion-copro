<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Compte de : {{ $proprietaire->nom }} {{ $proprietaire->prenom }}
            </h2>
            <div class="text-lg font-semibold">
                Solde : <span class="{{ $solde >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ number_format($solde, 2, ',', ' ') }} €</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Colonne des dettes (Appels de fonds non payés) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Quotes-parts d'appels dues</h3>
                        <div class="mt-4 flow-root">
                            @if($detailsAppelsNonPayes->isEmpty())
                                <p class="text-sm text-gray-500">Aucune quote-part en attente de paiement.</p>
                            @else
                                <ul role="list" class="-my-5 divide-y divide-gray-200">
                                    @foreach($detailsAppelsNonPayes as $detail)
                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $detail->appelDeFond->libelle }}</p>
                                                    <p class="text-sm text-gray-500 truncate">Lot {{ $detail->appelDeFond->lot->numero_lot }} - Échéance le {{ $detail->appelDeFond->date_echeance->format('d/m/Y') }}</p>
                                                </div>
                                                <div>
                                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                                        {{ number_format($detail->montant_quote_part, 2, ',', ' ') }} €
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Colonne des paiements (Règlements non affectés) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Règlements non affectés</h3>
                        <div class="mt-4 flow-root">
                            @if($reglementsNonLettres->isEmpty())
                                <p class="text-sm text-gray-500">Aucun règlement en attente d'affectation.</p>
                            @else
                                <ul role="list" class="-my-5 divide-y divide-gray-200">
                                    @foreach($reglementsNonLettres as $reglement)
                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $reglement->mode_de_reglement }}</p>
                                                    <p class="text-sm text-gray-500 truncate">Reçu le : {{ $reglement->date_reglement->format('d/m/Y') }}</p>
                                                </div>
                                                <div>
                                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                        {{ number_format($reglement->montant_regle, 2, ',', ' ') }} €
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                @if(!$detailsAppelsNonPayes->isEmpty())
                                    <div class="mt-6">
                                        <form action="{{ route('proprietaires.compte.lettrer', $proprietaire) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                Lancer le lettrage automatique
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
