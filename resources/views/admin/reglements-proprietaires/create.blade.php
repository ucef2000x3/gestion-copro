<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enregistrer un Règlement Propriétaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('reglements-proprietaires.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">Détails du Règlement</h2>
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                    <div class="sm:col-span-4">
                                        <label for="id_proprietaire" class="block text-sm font-medium leading-6 text-gray-900">Propriétaire</label>
                                        <select id="id_proprietaire" name="id_proprietaire" required class="mt-2 block w-full rounded-md ring-1">
                                            <option value="">-- Choisir un propriétaire --</option>
                                            @foreach ($proprietaires as $proprietaire)
                                                <option value="{{ $proprietaire->id_proprietaire }}" {{ old('id_proprietaire') == $proprietaire->id_proprietaire ? 'selected' : '' }}>
                                                    {{ $proprietaire->prenom }} {{ $proprietaire->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_proprietaire')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label for="id_exercice" class="block text-sm font-medium leading-6 text-gray-900">Imputer à l'Exercice</label>
                                        <select id="id_exercice" name="id_exercice" required class="mt-2 block w-full rounded-md ring-1">
                                            <option value="">-- Choisir un exercice --</option>
                                            @foreach ($exercices as $exercice)
                                                <option value="{{ $exercice->id_exercice }}" {{ old('id_exercice') == $exercice->id_exercice ? 'selected' : '' }}>
                                                    {{ $exercice->libelle }} ({{ $exercice->copropriete->nom_copropriete }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_exercice')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="montant_regle" class="block text-sm font-medium leading-6 text-gray-900">Montant Réglé</label>
                                        <input type="number" step="0.01" min="0.01" name="montant_regle" id="montant_regle" value="{{ old('montant_regle') }}" required class="mt-2 block w-full rounded-md ring-1">
                                        @error('montant_regle')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="date_reglement" class="block text-sm font-medium leading-6 text-gray-900">Date du règlement</label>
                                        <input type="date" name="date_reglement" id="date_reglement" value="{{ old('date_reglement', now()->format('Y-m-d')) }}" required class="mt-2 block w-full rounded-md ring-1">
                                        @error('date_reglement')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="mode_de_reglement" class="block text-sm font-medium leading-6 text-gray-900">Mode de règlement</label>
                                        <select id="mode_de_reglement" name="mode_de_reglement" required class="mt-2 block w-full rounded-md ring-1">
                                            <option {{ old('mode_de_reglement') == 'Virement' ? 'selected' : '' }}>Virement</option>
                                            <option {{ old('mode_de_reglement') == 'Chèque' ? 'selected' : '' }}>Chèque</option>
                                            <option {{ old('mode_de_reglement') == 'Prélèvement' ? 'selected' : '' }}>Prélèvement</option>
                                            <option {{ old('mode_de_reglement') == 'Espèces' ? 'selected' : '' }}>Espèces</option>
                                        </select>
                                        @error('mode_de_reglement')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-full">
                                        <label for="reference_paiement" class="block text-sm font-medium leading-6 text-gray-900">Référence (Optionnel)</label>
                                        <input type="text" name="reference_paiement" id="reference_paiement" value="{{ old('reference_paiement') }}" class="mt-2 block w-full rounded-md ring-1" placeholder="N° de chèque, ID transaction...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('reglements-proprietaires.index') }}" class="text-sm font-semibold">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
