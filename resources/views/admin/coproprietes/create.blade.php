<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter une nouvelle Copropriété') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('coproprietes.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">Informations de la Copropriété</h2>
                                <p class="mt-1 text-sm text-gray-500">Renseignez les détails de la nouvelle copropriété.</p>

                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="nom_copropriete" class="block text-sm font-medium leading-6 text-gray-900">Nom de la copropriété</label>
                                        <div class="mt-2">
                                            <input type="text" name="nom_copropriete" id="nom_copropriete" value="{{ old('nom_copropriete') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                        @error('nom_copropriete')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label for="id_residence" class="block text-sm font-medium leading-6 text-gray-900">Résidence parente</label>
                                        <div class="mt-2">
                                            <select id="id_residence" name="id_residence" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
                                                <option value="">-- Choisir une résidence --</option>
                                                @foreach ($residences as $residence)
                                                    <option value="{{ $residence->id_residence }}"
                                                            {{-- On désactive si le statut de la résidence est faux --}}
                                                            @if(!$residence->statut) disabled @endif
                                                        {{ old('id_residence') == $residence->id_residence ? 'selected' : '' }}
                                                    >
                                                        {{ $residence->nom_residence }}
                                                        {{-- On ajoute le tag visuel si le statut est faux --}}
                                                        @if(!$residence->statut)
                                                            <span class="text-red-400 pl-2">(Inactive)</span>
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('id_residence')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="col-span-full">
                                        <label for="adresse" class="block text-sm font-medium leading-6 text-gray-900">Adresse</label>
                                        <div class="mt-2"><input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                    </div>

                                    <div class="sm:col-span-2 sm:col-start-1">
                                        <label for="code_postal" class="block text-sm font-medium leading-6 text-gray-900">Code Postal</label>
                                        <div class="mt-2"><input type="text" name="code_postal" id="code_postal" value="{{ old('code_postal') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="ville" class="block text-sm font-medium leading-6 text-gray-900">Ville</label>
                                        <div class="mt-2"><input type="text" name="ville" id="ville" value="{{ old('ville') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="statut" class="block text-sm font-medium leading-6 text-gray-900">Statut</label>
                                        <div class="mt-2">
                                            <select id="statut" name="statut" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                <option value="1" {{ old('statut', '1') == '1' ? 'selected' : '' }}>Actif</option>
                                                <option value="0" {{ old('statut') == '0' ? 'selected' : '' }}>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('coproprietes.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
