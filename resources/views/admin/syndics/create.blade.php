<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un nouveau Syndic') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('syndics.store') }}" method="POST">
                        @csrf <!-- Protection de sécurité indispensable de Laravel -->

                        <div class="space-y-6">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">Informations du Syndic</h2>
                                <p class="mt-1 text-sm text-gray-500">Renseignez le nom de l'entreprise du syndic.</p>
                            </div>

                            <div>
                                <label for="nom_entreprise" class="block text-sm font-medium leading-6 text-gray-900">Nom de l'entreprise</label>
                                <div class="mt-2">
                                    <input type="text"
                                           name="nom_entreprise"
                                           id="nom_entreprise"
                                           value="{{ old('nom_entreprise') }}"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                           placeholder="Ex: Syndic & Co">
                                </div>
                                @error('nom_entreprise')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-6">
                                <label for="statut" class="block text-sm font-medium leading-6 text-gray-900">Statut</label>
                                <select id="statut" name="statut" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">

                                    {{-- Pour `edit.blade.php`, `$syndic` existe. Pour `create.blade.php`, il n'existe pas. --}}
                                    {{-- L'opérateur `?? true` gère le cas de la création en mettant 'Actif' par défaut. --}}
                                    <option value="1" @if(old('statut', $syndic->statut ?? true) == true) selected @endif>
                                        Actif
                                    </option>
                                    <option value="0" @if(old('statut', $syndic->statut ?? true) == false) selected @endif>
                                        Inactif
                                    </option>
                                </select>
                                @error('statut')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions du formulaire -->
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('syndics.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Sauvegarder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
