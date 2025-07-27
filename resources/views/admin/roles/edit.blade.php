<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le Rôle :') }} {{ $role->getTranslated('nom_role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-8">
                            <!-- Section 1 : Détails du Rôle (inchangée) -->
                            <div class="space-y-6">
                                <div>
                                    <h2 class="text-lg font-medium leading-6 text-gray-900">Détails du Rôle</h2>
                                    <p class="mt-1 text-sm text-gray-500">Modifiez le nom du rôle dans les langues supportées.</p>
                                </div>
                                @foreach (config('languages.supported') as $locale => $language)
                                    <div>
                                        <label for="nom_role_{{ $locale }}" class="block text-sm font-medium leading-6 text-gray-900">Nom ({{ $language }})</label>
                                        <div class="mt-2"><input type="text" name="nom_role[{{ $locale }}]" id="nom_role_{{ $locale }}" value="{{ old('nom_role.' . $locale, $role->nom_role[$locale] ?? '') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                        @error('nom_role.' . $locale)<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                @endforeach
                            </div>

                            <!-- ========================================================= -->
                            <!-- == NOUVELLE SECTION : GESTION DES PERMISSIONS == -->
                            <!-- ========================================================= -->
                            <div class="space-y-6 pt-8">
                                <div>
                                    <h2 class="text-lg font-medium leading-6 text-gray-900">Permissions Associées</h2>
                                    <p class="mt-1 text-sm text-gray-500">Cochez les permissions que ce rôle doit posséder.</p>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach ($permissions as $permission)
                                        <div class="relative flex items-start">
                                            <div class="flex h-6 items-center">
                                                <input id="permission_{{ $permission->id_permission }}"
                                                       name="permissions[]"
                                                       value="{{ $permission->id_permission }}"
                                                       type="checkbox"
                                                       {{-- On coche la case si le rôle possède déjà cette permission --}}
                                                       @if($role->permissions->contains($permission)) checked @endif
                                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                            </div>
                                            <div class="ml-3 text-sm leading-6">
                                                <label for="permission_{{ $permission->id_permission }}" class="font-medium text-gray-900">{{ $permission->getTranslated('nom_permission') }}</label>
                                                <p class="text-xs text-gray-500 font-mono">{{ $permission->cle }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('permissions')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <!-- Actions du formulaire -->
                        <div class="mt-8 flex items-center justify-end gap-x-6">
                            <a href="{{ route('roles.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Annuler</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
