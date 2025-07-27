<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Ajouter un nouveau Rôle') }}</h2></x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">Détails du Rôle</h2>
                                <p class="mt-1 text-sm text-gray-500">Renseignez le nom du rôle dans les langues supportées.</p>
                            </div>

                            <div class="space-y-6">
                                <!-- Boucle dynamique sur les langues configurées -->
                                @foreach (config('languages.supported') as $locale => $language)
                                    <div>
                                        <label for="nom_role_{{ $locale }}" class="block text-sm font-medium leading-6 text-gray-900">
                                            Nom ({{ $language }})
                                        </label>
                                        <div class="mt-2">
                                            <input type="text"
                                                   name="nom_role[{{ $locale }}]"
                                                   id="nom_role_{{ $locale }}"
                                                   value="{{ old('nom_role.' . $locale) }}"
                                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                        @error('nom_role.' . $locale)
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('roles.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
