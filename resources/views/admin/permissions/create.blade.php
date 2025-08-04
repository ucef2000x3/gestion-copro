<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Ajouter une nouvelle Permission') }}</h2></x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">Détails de la Permission</h2>
                                <p class="mt-1 text-sm text-gray-500">La clé est l'identifiant unique utilisé dans le code. Le nom est affiché à l'utilisateur.</p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="cle" class="block text-sm font-medium leading-6 text-gray-900">Clé de la permission</label>
                                    <div class="mt-2"><input type="text" name="cle" id="cle" value="{{ old('cle') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300" placeholder="ex: syndic:creer"></div>
                                    @error('cle')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <!-- Boucle dynamique sur les langues configurées -->
                                @foreach (config('languages.supported') as $locale => $language)
                                    <div>
                                        <label for="nom_permission_{{ $locale }}" class="block text-sm font-medium leading-6 text-gray-900">Nom ({{ $language }})</label>
                                        <div class="mt-2">
                                            <input type="text" name="nom_permission[{{ $locale }}]" id="nom_permission_{{ $locale }}" value="{{ old('nom_permission.' . $locale) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300" placeholder="Ex: Créer un syndic">
                                        </div>
                                        @error('nom_permission.' . $locale)<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('permissions.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
