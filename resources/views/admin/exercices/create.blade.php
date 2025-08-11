<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Ajouter un Exercice Comptable') }}</h2></x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('exercices.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">Détails de l'Exercice</h2>
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="id_copropriete" class="block text-sm font-medium">Copropriété</label>
                                        <select id="id_copropriete" name="id_copropriete" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                            <option value="">-- Choisir une copropriété --</option>
                                            @foreach ($coproprietes as $copropriete)
                                                <option value="{{ $copropriete->id_copropriete }}" {{ old('id_copropriete') == $copropriete->id_copropriete ? 'selected' : '' }}>{{ $copropriete->nom_copropriete }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_copropriete')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-full">
                                        <label for="libelle" class="block text-sm font-medium leading-6 text-gray-900">Libellé de l'exercice</label>
                                        <div class="mt-2">
                                            <input type="text"
                                                   name="libelle"
                                                   id="libelle"
                                                   value="{{ old('libelle') }}" {{-- Pour create.blade.php --}}
                                                   {{-- value="{{ old('libelle', $exercice->libelle) }}" --}} {{-- Pour edit.blade.php --}}
                                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"
                                                   placeholder="Ex: Exercice Annuel 2025">
                                        </div>
                                        @error('libelle')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="date_debut" class="block text-sm font-medium">Date de début</label>
                                        <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                        @error('date_debut')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="date_fin" class="block text-sm font-medium">Date de fin</label>
                                        <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                        @error('date_fin')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="statut" class="block text-sm font-medium">Statut</label>
                                        <select id="statut" name="statut" class="mt-2 block w-full rounded-md ring-1">
                                            {{-- On boucle sur tous les cas possibles de l'Enum --}}
                                            @foreach (App\Enums\StatutExercice::cases() as $statutEnum)
                                                <option value="{{ $statutEnum->value }}" {{ old('statut') == $statutEnum->value ? 'selected' : '' }}>
                                                    {{ $statutEnum->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('exercices.index') }}" class="text-sm font-semibold">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
