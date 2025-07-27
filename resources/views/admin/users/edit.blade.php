<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier Utilisateur :') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Message de succès global pour la page -->
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- PANNEAU 1: Informations de base (utilisant le partiel de Breeze) -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- Note: Ce formulaire pointe vers la route 'profile.update'.
                         Pour une gestion admin complète, il est mieux de le remplacer par un formulaire
                         pointant vers 'users.update'. Nous faisons cela dans le panneau suivant. --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- PANNEAU 2: Rôles Globaux et Super Admin -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Rôles et Statut</h2>
                            <p class="mt-1 text-sm text-gray-600">Assignez des rôles globaux ou le statut de Super Administrateur.</p>
                        </header>

                        <form action="{{ route('users.update', $user) }}" method="POST" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Champ caché pour le nom et l'email pour passer la validation du contrôleur -->
                            <input type="hidden" name="name" value="{{$user->name}}">
                            <input type="hidden" name="email" value="{{$user->email}}">

                            <div>
                                <h3 class="font-medium text-gray-800 mb-2">Rôles Globaux</h3>
                                <p class="mt-1 text-sm text-gray-500">Donne les permissions associées sur <strong>toute l'application</strong>.</p>
                                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach ($allRoles as $role)
                                        <div class="relative flex items-start">
                                            <div class="flex h-6 items-center">
                                                <input id="role_{{ $role->id_role }}"
                                                       name="roles[]"
                                                       value="{{ $role->id_role }}"
                                                       type="checkbox"
                                                       @if(in_array($role->id_role, $userGlobalRoleIds)) checked @endif
                                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                            </div>
                                            <div class="ml-3 text-sm leading-6">
                                                <label for="role_{{ $role->id_role }}" class="font-medium text-gray-900">{{ $role->getTranslated('nom_role') }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @can('assignSuperAdmin', App\Models\User::class)
                                <div class="border-t border-gray-200 pt-6">
                                    <h3 class="font-medium text-red-700 mb-2">Zone Super Administrateur</h3>
                                    <div class="relative flex items-start">
                                        <div class="flex h-6 items-center">
                                            <input id="is_super_admin" name="is_super_admin" type="checkbox" value="1"
                                                   @if(old('is_super_admin', $user->is_super_admin)) checked @endif
                                                   class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
                                        </div>
                                        <div class="ml-3 text-sm leading-6">
                                            <label for="is_super_admin" class="font-medium text-gray-900">
                                                Cet utilisateur est un Super Administrateur
                                            </label>
                                            <p class="text-xs text-gray-500">Donne un accès total et inconditionnel à toute l'application.</p>
                                        </div>
                                    </div>
                                </div>
                            @endcan

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Sauvegarder les Rôles') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!-- PANNEAU 3: Affectations Spécifiques -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Affectations Spécifiques</h2>
                        <p class="mt-1 text-sm text-gray-600">Donne un rôle uniquement sur un périmètre précis. Utile si aucun rôle global n'est coché.</p>
                    </header>

                    <!-- Formulaire pour ajouter une affectation -->
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg border">
                        <h3 class="font-medium text-gray-800 mb-4">Ajouter une nouvelle affectation</h3>
                        <form action="{{ route('users.affectations.store', $user) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                            @csrf
                            <div>
                                <label for="id_role" class="block text-sm font-medium">Attribuer le Rôle</label>
                                <select name="id_role" id="id_role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                    <option value="">-- Choisir un rôle --</option>
                                    @foreach ($allRoles as $role)
                                        <option value="{{ $role->id_role }}">{{ $role->getTranslated('nom_role') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="affectable" class="block text-sm font-medium">Sur le périmètre</label>
                                <select name="affectable" id="affectable" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                    <option value="">-- Choisir un périmètre --</option>
                                    <optgroup label="Syndics">
                                        @foreach ($syndics as $syndic)
                                            <option value="{{ get_class($syndic) }}:{{ $syndic->id_syndic }}">{{ $syndic->nom_entreprise }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Résidences">
                                        @foreach ($residences as $residence)
                                            <option value="{{ get_class($residence) }}:{{ $residence->id_residence }}">{{ $residence->nom_residence }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <x-primary-button type="submit">{{ __('Ajouter') }}</x-primary-button>
                        </form>
                    </div>

                    <!-- Liste des affectations existantes -->
                    <div class="mt-6">
                        <h3 class="font-medium text-gray-800 mb-2">Affectations actuelles</h3>
                        <ul role="list" class="divide-y divide-gray-200">
                            @forelse($user->affectations as $affectation)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <span class="font-bold">{{ $affectation->role->getTranslated('nom_role') }}</span> sur
                                        <span class="text-gray-600">{{ $affectation->affectable->nom_entreprise ?? $affectation->affectable->nom_residence ?? 'Périmètre non défini' }}</span>
                                        <span class="text-xs text-gray-400">({{ class_basename($affectation->affectable_type) }})</span>
                                    </div>
                                    <form action="{{ route('users.affectations.destroy', [$user, $affectation]) }}" method="POST" onsubmit="return confirm('Retirer cette affectation ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">Retirer</button>
                                    </form>
                                </li>
                            @empty
                                <li class="py-3 text-sm text-gray-500">Cet utilisateur n'a aucune affectation spécifique.</li>
                            @endforelse
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
