<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Ajouter un nouveau Lot') }}</h2></x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('lots.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">Informations du Lot</h2>
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="id_copropriete" class="block text-sm font-medium leading-6 text-gray-900">Copropriété parente</label>
                                        <div class="mt-2">
                                            <select id="id_copropriete" name="id_copropriete" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
                                                <option value="">-- Choisir une copropriété --</option>
                                                @foreach ($coproprietes as $copropriete)
                                                    <option value="{{ $copropriete->id_copropriete }}" {{ old('id_copropriete') == $copropriete->id_copropriete ? 'selected' : '' }}>{{ $copropriete->nom_copropriete }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('id_copropriete')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="numero_lot" class="block text-sm font-medium">Numéro du lot</label>
                                        <div class="mt-2"><input type="text" name="numero_lot" id="numero_lot" value="{{ old('numero_lot') }}" class="block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300"></div>
                                        @error('numero_lot')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="nombre_tantiemes" class="block text-sm font-medium">Nombre de tantièmes</label>
                                        <div class="mt-2"><input type="number" name="nombre_tantiemes" id="nombre_tantiemes" value="{{ old('nombre_tantiemes', 0) }}" class="block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300"></div>
                                        @error('nombre_tantiemes')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="statut" class="block text-sm font-medium">Statut</label>
                                        <select id="statut" name="statut" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                            <option value="1" {{ old('statut', '1') == '1' ? 'selected' : '' }}>Actif</option>
                                            <option value="0" {{ old('statut') == '0' ? 'selected' : '' }}>Inactif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('lots.index') }}" class="text-sm font-semibold">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
