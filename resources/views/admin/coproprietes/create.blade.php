<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Condominium') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('coproprietes.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">{{ __('Condominium Information') }}</h2>
                                <p class="mt-1 text-sm text-gray-500">{{ __('Fill Condominium Details') }}</p>
                            </div>

                            <!-- Champ Nom de la résidence -->
                            <div>
                                <label for="nom_copropriete" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Condominium Name') }}</label>
                                <div class="mt-2">
                                    <input type="text"
                                           name="nom_copropriete"
                                           id="nom_copropriete"
                                           value="{{ old('nom_copropriete') }}"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                           placeholder="Ex: Les Jardins du Parc">
                                </div>
                                @error('nom_copropriete')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Champ Syndic de gestion (menu déroulant) -->
                            <!-- Champ Syndic de gestion (menu déroulant avec statut) -->
                            <div>
                                <label for="id_syndic" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Syndic') }}</label>
                                <div class="mt-2">
                                    <select id="id_syndic" name="id_syndic" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option value="">-- {{ __('Select Syndic') }} --</option>

                                        @foreach ($syndics as $syndic)
                                            <option value="{{ $syndic->id_syndic }}"
                                                    {{-- On désactive l'option si le statut n'est pas 'actif' --}}
                                                    @if(!$syndic->statut) disabled @endif
                                                {{-- On pré-sélectionne en cas d'erreur de validation --}}
                                                {{ old('id_syndic') == $syndic->id_syndic ? 'selected' : '' }}
                                            >
                                                {{ $syndic->nom_entreprise }}
                                                {{-- On ajoute le tag visuel si le statut n'est pas 'actif' --}}
                                                @if(!$syndic->statut)
                                                    ({{ __('Inactive') }})
                                                @endif
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('id_syndic')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions du formulaire -->
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('coproprietes.index') }}" class="text-sm font-semibold leading-6 text-gray-900">{{ __('Cancel') }}</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
