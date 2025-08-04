<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Condominium') }} : {{ $copropriete->nom_copropriete }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('coproprietes.update', $copropriete) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">{{ __('Condominium Information') }} </h2>
                                <p class="mt-1 text-sm text-gray-500">{{ __('Edit Condominium Details') }}</p>
                            </div>

                            <!-- Champ Nom de la résidence -->
                            <div>
                                <label for="nom_copropriete" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Condominium Name') }}</label>
                                <div class="mt-2">
                                    <input type="text"
                                           name="nom_copropriete"
                                           id="nom_copropriete"
                                           value="{{ old('nom_copropriete', $copropriete->nom_copropriete) }}"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                                @error('nom_copropriete')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Champ Syndic de gestion (menu déroulant) -->
                            <div>
                                <label for="id_syndic" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Syndic') }}</label>
                                <div class="mt-2">
                                    <select id="id_syndic" name="id_syndic" class="block w-full ...">
                                        <option value="">-- {{ __('Select Syndic') }} --</option>

                                        @foreach ($syndics as $syndic)
                                            <option value="{{ $syndic->id_syndic }}"

                                                    {{-- Condition 1 : Est-ce que cette option doit être pré-sélectionnée ? --}}
                                                    @if(old('id_syndic', $copropriete->id_syndic) == $syndic->id_syndic)
                                                        selected
                                                    @endif

                                                    {{-- Condition 2 : Est-ce que cette option doit être désactivée ? --}}
                                                    {{-- Elle doit être désactivée si, et seulement si, le statut du syndic n'est pas 'actif'. --}}
                                                    @if($syndic->statut !== true)
                                                        disabled
                                                @endif
                                            >
                                                {{ $syndic->nom_entreprise }}

                                                {{-- On ajoute le tag visuel si le statut n'est pas 'actif' --}}
                                                @if($syndic->statut !== true)
                                                    <span class="text-red-500 font-semibold">({{ __('Inactive') }})</span>
                                                @endif
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('id_syndic')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-6">
                                <label for="statut" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Status') }}</label>
                                <select id="statut" name="statut" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">

                                    {{-- Pour `edit.blade.php`, `$syndic` existe. Pour `create.blade.php`, il n'existe pas. --}}
                                    {{-- L'opérateur `?? true` gère le cas de la création en mettant 'Actif' par défaut. --}}
                                    <option value="1" @if(old('statut', $copropriete->statut) == 1) selected @endif>{{ __('Active') }}</option>
                                    <option value="0" @if(old('statut', $copropriete->statut) == 0) selected @endif>{{ __('Inactive') }}</option>
                                </select>
                                @error('statut')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions du formulaire -->
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('coproprietes.index') }}" class="text-sm font-semibold leading-6 text-gray-900">{{ __('Cancel') }}</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
