<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un nouveau Propriétaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    {{-- x-data=" ... " initialise une variable Alpine.js 'type' --}}
                    <form action="{{ route('proprietaires.store') }}" method="POST" x-data="{ type: '{{ old('type_proprietaire', 'personne_physique') }}' }">
                        @csrf
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">Informations du Propriétaire</h2>
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                    <!-- Champ Type de Propriétaire -->
                                    <div class="sm:col-span-3">
                                        <label for="type_proprietaire" class="block text-sm font-medium">Type de propriétaire</label>
                                        {{-- @change="type = $event.target.value" met à jour la variable Alpine 'type' quand on change la sélection --}}
                                        <select id="type_proprietaire" name="type_proprietaire" @change="type = $event.target.value" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                            <option value="personne_physique" {{ old('type_proprietaire', 'personne_physique') == 'personne_physique' ? 'selected' : '' }}>Personne Physique</option>
                                            <option value="personne_morale" {{ old('type_proprietaire') == 'personne_morale' ? 'selected' : '' }}>Personne Morale</option>
                                        </select>
                                    </div>

                                    <!-- Champ Nom / Raison Sociale -->
                                    <div class="sm:col-span-3">
                                        {{-- :class="{'opacity-50': type === 'personne_physique'}" est une syntaxe Alpine qui ajoute une classe conditionnellement --}}
                                        <label for="nom" class="block text-sm font-medium" x-text="type === 'personne_physique' ? 'Nom de famille' : 'Raison Sociale'"></label>
                                        <div class="mt-2"><input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                        @error('nom')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <!-- Champs Personne Physique (visibles conditionnellement) -->
                                    <template x-if="type === 'personne_physique'">
                                        <div class="contents">
                                            <div class="sm:col-span-2"><label for="civilite" class="block text-sm font-medium">Civilité</label><input type="text" name="civilite" id="civilite" value="{{ old('civilite') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                            <div class="sm:col-span-4"><label for="prenom" class="block text-sm font-medium">Prénom</label><input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                        </div>
                                    </template>

                                    <!-- Champs Personne Morale (visibles conditionnellement) -->
                                    <template x-if="type === 'personne_morale'">
                                        <div class="contents">
                                            <div class="sm:col-span-3"><label for="forme_juridique" class="block text-sm font-medium">Forme Juridique</label><input type="text" name="forme_juridique" id="forme_juridique" value="{{ old('forme_juridique') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                            <div class="sm:col-span-3"><label for="numero_siret" class="block text-sm font-medium">N° SIRET</label><input type="text" name="numero_siret" id="numero_siret" value="{{ old('numero_siret') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                        </div>
                                    </template>

                                    <div class="sm:col-span-3"><label for="email" class="block text-sm font-medium">Email de contact</label><input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                    <div class="sm:col-span-3"><label for="telephone_contact" class="block text-sm font-medium">Téléphone</label><input type="text" name="telephone_contact" id="telephone_contact" value="{{ old('telephone_contact') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1"></div>

                                    <div class="col-span-full border-t pt-8 mt-4">
                                        <label for="id_utilisateur" class="block text-sm font-medium">Lier à un compte utilisateur (Optionnel)</label>
                                        <p class="text-xs text-gray-500">Permet au propriétaire de se connecter à l'extranet.</p>
                                        <select id="id_utilisateur" name="id_utilisateur" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                            <option value="">-- Ne pas lier de compte --</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('id_utilisateur') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{$user->email}})</option>
                                            @endforeach
                                        </select>
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
                            <a href="{{ route('proprietaires.index') }}" class="text-sm font-semibold">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
