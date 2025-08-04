<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Residence') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form action="{{ route('residences.store') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium leading-6 text-gray-900">{{ __('Residence Information') }}</h2>
                                <p class="mt-1 text-sm text-gray-500">{{ __('Fill Residence Details') }}</p>

                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="nom_residence" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Residence Name') }}</label>
                                        <div class="mt-2">
                                            <input type="text" name="nom_residence" id="nom_residence" value="{{ old('nom_residence') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                        @error('nom_residence')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label for="id_copropriete" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Condominium') }}</label>
                                        <div class="mt-2">
                                            <select id="id_copropriete" name="id_copropriete" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
                                                <option value="">-- {{ __('Select Condominium') }} --</option>
                                                @foreach ($coproprietes as $copropriete)
                                                    <option value="{{ $copropriete->id_copropriete }}"
                                                            {{-- On désactive si le statut de la résidence est faux --}}
                                                            @if(!$copropriete->statut) disabled @endif
                                                        {{ old('id_copropriete') == $copropriete->id_copropriete ? 'selected' : '' }}
                                                    >
                                                        {{ $copropriete->nom_copropriete }}
                                                        {{-- On ajoute le tag visuel si le statut est faux --}}
                                                        @if(!$copropriete->statut)
                                                            <span class="text-red-400 pl-2">({{ __('Inactive') }})</span>
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('id_copropriete')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="col-span-full">
                                        <label for="adresse" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Adress') }}</label>
                                        <div class="mt-2"><input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                    </div>

                                    <div class="sm:col-span-2 sm:col-start-1">
                                        <label for="code_postal" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Zipcode') }}</label>
                                        <div class="mt-2"><input type="text" name="code_postal" id="code_postal" value="{{ old('code_postal') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="ville" class="block text-sm font-medium leading-6 text-gray-900">{{ __('City') }}</label>
                                        <div class="mt-2"><input type="text" name="ville" id="ville" value="{{ old('ville') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"></div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="statut" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Status') }}</label>
                                        <div class="mt-2">
                                            <select id="statut" name="statut" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                <option value="1" {{ old('statut', '1') == '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                <option value="0" {{ old('statut') == '0' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('residences.index') }}" class="text-sm font-semibold leading-6 text-gray-900">{{ __('Cancel') }}</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
