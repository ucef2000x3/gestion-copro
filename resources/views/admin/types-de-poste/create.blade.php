<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Ajouter un Type de Poste') }}</h2></x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('types-de-poste.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">Détails du Type de Poste</h2>
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

                                    <div class="sm:col-span-4">
                                        <label for="libelle" class="block text-sm font-medium">Libellé du poste</label>
                                        <div class="mt-2"><input type="text" name="libelle" id="libelle" value="{{ old('libelle') }}" class="block w-full rounded-md border-0 py-1.5 ring-1" placeholder="Ex: Entretien ascenseur"></div>
                                        @error('libelle')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="code_comptable" class="block text-sm font-medium">Code Comptable (Optionnel)</label>
                                        <div class="mt-2"><input type="text" name="code_comptable" id="code_comptable" value="{{ old('code_comptable') }}" class="block w-full rounded-md border-0 py-1.5 ring-1" placeholder="Ex: 615"></div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="statut" class="block text-sm font-medium">Statut</label>
                                        <select id="statut" name="statut" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                            <option value="1" selected>Actif</option>
                                            <option value="0">Inactif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('types-de-poste.index') }}" class="text-sm font-semibold">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
