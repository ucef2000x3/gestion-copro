<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le Fournisseur :') }} {{ $fournisseur->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('fournisseurs.update', $fournisseur) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">Informations du Fournisseur</h2>
                                <div class="mt-6 grid grid-cols-1 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="nom" class="block text-sm font-medium leading-6 text-gray-900">Nom du fournisseur</label>
                                        <div class="mt-2">
                                            <input type="text" name="nom" id="nom" value="{{ old('nom', $fournisseur->nom) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
                                        </div>
                                        @error('nom')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-1">
                                        <label for="statut" class="block text-sm font-medium leading-6 text-gray-900">Statut</label>
                                        <div class="mt-2">
                                            <select id="statut" name="statut" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
                                                <option value="1" @if(old('statut', $fournisseur->statut) == 1) selected @endif>Actif</option>
                                                <option value="0" @if(old('statut', $fournisseur->statut) == 0) selected @endif>Inactif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('fournisseurs.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
