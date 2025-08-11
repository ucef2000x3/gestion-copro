<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Générer les Appels de Fonds pour {{ $exercice->libelle }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <p>Copropriété: <strong>{{ $exercice->copropriete->nom_copropriete }}</strong></p>
                <p>Budget Prévisionnel Total: <strong>{{ number_format($totalBudget, 2, ',', ' ') }} {{ $exercice->copropriete->devise->symbole ?? '€' }}</strong></p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('exercices.appels.store', $exercice) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div><label for="libelle">Libellé de l'appel</label><input type="text" name="libelle" id="libelle" class="mt-1 block w-full ring-1" value="{{ old('libelle', 'Appel de fonds T1 ' . $exercice->date_debut->year) }}"></div>
                            <div><label for="montant_total_a_appeler">Montant total à appeler</label><input type="number" step="0.01" name="montant_total_a_appeler" id="montant_total_a_appeler" value="{{ old('montant_total_a_appeler', number_format($totalBudget / 4, 2, '.', '')) }}" class="mt-1 block w-full ring-1"></div>
                            <div><label for="date_appel">Date de l'appel</label><input type="date" name="date_appel" id="date_appel" value="{{ old('date_appel', now()->format('Y-m-d')) }}" class="mt-1 block w-full ring-1"></div>
                            <div><label for="date_echeance">Date d'échéance</label><input type="date" name="date_echeance" id="date_echeance" value="{{ old('date_echeance', now()->addDays(30)->format('Y-m-d')) }}" class="mt-1 block w-full ring-1"></div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Générer les Appels</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
