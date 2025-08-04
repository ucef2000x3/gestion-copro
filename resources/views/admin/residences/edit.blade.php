<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Residence') }} : {{ $residence->nom_residence }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('residences.update', $residence) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">{{ __('Residence Information') }} </h2>
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="nom_residence" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Residence Name') }}</label>
                                        <div class="mt-2"><input type="text" name="nom_residence" id="nom_residence" value="{{ old('nom_residence', $residence->nom_residence) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                        @error('nom_residence')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>


                                    <div class="sm:col-span-4">
                                        <label for="id_copropriete" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Condominium') }} </label>
                                        <div class="mt-2">
                                            <select id="id_copropriete" name="id_copropriete" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
                                                <option value="">-- {{ __('Select Condominium') }}  --</option>
                                                @foreach ($coproprietes as $copropriete)
                                                    <option value="{{ $copropriete->id_copropriete }}"
                                                            {{-- Condition 1 : Pré-sélectionner la valeur existante --}}
                                                            @if(old('id_copropriete', $residence->id_copropriete) == $copropriete->id_copropriete) selected @endif

                                                            {{-- Condition 2 : Désactiver si la résidence est inactive --}}
                                                            @if(!$copropriete->statut) disabled @endif
                                                    >
                                                        {{ $copropriete->nom_copropriete}}
                                                        @if(!$copropriete->statut)
                                                            <span class="text-gray-500 font-normal">({{ __('Inactive') }} )</span>
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('id_copropriete')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>



                                    <div class="col-span-full">
                                        <label for="adresse" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Adress') }} </label>
                                        <div class="mt-2"><input type="text" name="adresse" id="adresse" value="{{ old('adresse', $residence->adresse) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                    </div>

                                    <div class="sm:col-span-2 sm:col-start-1">
                                        <label for="code_postal" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Zipcode') }} </label>
                                        <div class="mt-2"><input type="text" name="code_postal" id="code_postal" value="{{ old('code_postal', $residence->code_postal) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="ville" class="block text-sm font-medium leading-6 text-gray-900">{{ __('City') }} </label>
                                        <div class="mt-2"><input type="text" name="ville" id="ville" value="{{ old('ville', $residence->ville) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="statut" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Status') }} </label>
                                        <div class="mt-2">
                                            <select id="statut" name="statut" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
                                                <option value="1" @if(old('statut', $residence->statut) == 1) selected @endif>{{ __('Active') }}</option>
                                                <option value="0" @if(old('statut', $residence->statut) == 0) selected @endif>{{ __('Inactive') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('residences.index') }}" class="text-sm font-semibold leading-6 text-gray-900">{{ __('Cancel') }} </a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">{{ __('Update') }} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
