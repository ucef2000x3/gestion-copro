<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Modifier le Type de Poste :') }} {{ $typeDePoste->libelle }}</h2></x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('types-de-poste.update', $typeDePoste) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium">Détails du Type de Poste</h2>
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="id_copropriete" class="block text-sm font-medium">Copropriété</label>
                                        <select id="id_copropriete" name="id_copropriete" class="mt-2 block w-full rounded-md ring-1">
                                            @foreach ($coproprietes as $copropriete)
                                                <option value="{{ $copropriete->id_copropriete }}" @if(old('id_copropriete', $typeDePoste->id_copropriete) == $copropriete->id_copropriete) selected @endif>{{ $copropriete->nom_copropriete }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_copropriete')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label for="libelle" class="block text-sm font-medium">Libellé du poste</label>
                                        <div class="mt-2"><input type="text" name="libelle" id="libelle" value="{{ old('libelle', $typeDePoste->libelle) }}" class="block w-full rounded-md ring-1"></div>
                                        @error('libelle')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="code_comptable" class="block text-sm font-medium">Code Comptable</label>
                                        <div class="mt-2"><input type="text" name="code_comptable" id="code_comptable" value="{{ old('code_comptable', $typeDePoste->code_comptable) }}" class="block w-full rounded-md ring-1"></div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="statut" class="block text-sm font-medium">Statut</label>
                                        <select id="statut" name="statut" class="mt-2 block w-full rounded-md ring-1">
                                            <option value="1" @if(old('statut', $typeDePoste->statut) == 1) selected @endif>Actif</option>
                                            <option value="0" @if(old('statut', $typeDePoste->statut) == 0) selected @endif>Inactif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('types-de-poste.index') }}" class="text-sm font-semibold">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
