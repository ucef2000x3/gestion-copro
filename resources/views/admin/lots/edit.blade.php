<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lot') }} : {{ $lot->numero_lot }}
            <span class="text-base text-gray-500 font-normal ml-2">
                ({{ __('Residence') }}: {{ $lot->residence->nom_residence ?? 'N/A' }})
            </span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
                    @if ($errors->any())<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">{{ session('Correct Errors') }}</div>@endif

                    <!-- ========================================================= -->
                    <!-- == FORMULAIRE 1 : INFORMATIONS DU LOT == -->
                    <!-- ========================================================= -->
                    <form action="{{ route('lots.update', $lot) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-8">
                            <div>
                                <h2 class="text-lg font-medium">{{ __('Lot Informations') }}</h2>
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="id_residence" class="block text-sm font-medium">{{ __('Residence') }}</label>
                                        <select id="id_residence" name="id_residence" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                            @foreach ($residences as $residence)
                                                <option value="{{ $residence->id_residence }}"
                                                        @if(old('id_residence', $lot->id_residence) == $residence->id_residence) selected @endif
                                                        @if(!$residence->statut && $lot->id_residence != $residence->id_residence) disabled @endif
                                                >
                                                    {{ $residence->nom_residence }}
                                                    @if(!$residence->statut) ({{ __('Inactive') }}) @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_residence')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="numero_lot" class="block text-sm font-medium">{{ __('Lot Number') }}</label>
                                        <div class="mt-2"><input type="text" name="numero_lot" id="numero_lot" value="{{ old('numero_lot', $lot->numero_lot) }}" class="block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                        @error('numero_lot')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="nombre_tantiemes" class="block text-sm font-medium">{{ __('Tantiemes') }}</label>
                                        <div class="mt-2"><input type="number" name="nombre_tantiemes" id="nombre_tantiemes" value="{{ old('nombre_tantiemes', $lot->nombre_tantiemes) }}" class="block w-full rounded-md border-0 py-1.5 ring-1"></div>
                                        @error('nombre_tantiemes')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="statut" class="block text-sm font-medium">{{ __('Status') }}</label>
                                        <select id="statut" name="statut" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1">
                                            <option value="1" @if(old('statut', $lot->statut) == 1) selected @endif>{{ __('Active') }}</option>
                                            <option value="0" @if(old('statut', $lot->statut) == 0) selected @endif>{{ __('Inactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6 border-b pb-8 border-gray-200">
                            <a href="{{ route('lots.index') }}" class="text-sm font-semibold">{{ __('Cancel') }}</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">{{ __('Update') }}</button>
                        </div>
                    </form>

                    <!-- ========================================================= -->
                    <!-- == SECTION 2 : GESTION DES PROPRIÉTAIRES == -->
                    <!-- ========================================================= -->
                    <div class="mt-8">
                        <h2 class="text-lg font-medium leading-6 text-gray-900">{{ __('Lot Owner') }}</h2>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Intro Lot Owner') }}</p>

                        <div class="mt-6 bg-gray-50 p-4 rounded-lg border">
                            <h3 class="font-medium text-gray-800 mb-4">{{ __('Add Owner') }}</h3>
                            <form action="{{ route('lots.proprietaires.store', $lot) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                                @csrf
                                <div class="col-span-2">
                                    <label for="id_proprietaire" class="block text-sm font-medium">{{ __('Select Owner') }}</label>
                                    <select name="id_proprietaire" id="id_proprietaire" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                        <option value="">-- {{ __('Available Owners') }} --</option>
                                        @foreach ($proprietaires_non_lies as $proprietaire)
                                            <option value="{{ $proprietaire->id_proprietaire }}">{{ $proprietaire->nom }} {{ $proprietaire->prenom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="pourcentage_possession" class="block text-sm font-medium">{{ __('Percentage') }} (%)</label>
                                    <input type="number" step="0.01" min="0.01" max="100" name="pourcentage_possession" id="pourcentage_possession" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="ex: 50.00">
                                </div>
                                <x-primary-button type="submit">{{ __('Add') }}</x-primary-button>
                            </form>
                            @if ($errors->has('pourcentage_possession'))<p class="mt-2 text-sm text-red-600">{{ $errors->first('pourcentage_possession') }}</p>@endif
                        </div>

                        <div class="mt-6">
                            <h3 class="font-medium text-gray-800 mb-2">{{ __('Current Owners') }}</h3>
                            <div class="border rounded-md">
                                <ul role="list" class="divide-y divide-gray-200">
                                    @forelse($lot->proprietaires as $proprietaire)
                                        <li class="px-4 py-3 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                            <div class="mb-2 sm:mb-0"><span class="font-bold">{{ $proprietaire->nom }} {{ $proprietaire->prenom }}</span></div>
                                            <div class="flex items-center space-x-4 w-full sm:w-auto">
                                                <form action="{{ route('lots.proprietaires.update', [$lot, $proprietaire]) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf @method('PATCH')
                                                    <input type="number" step="0.01" min="0.01" max="100" name="pourcentage_possession" value="{{ $proprietaire->pivot->pourcentage_possession }}" class="w-28 rounded-md border-gray-300 shadow-sm text-sm text-right">
                                                    <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-900">OK</button>
                                                </form>
                                                <form action="{{ route('lots.proprietaires.destroy', [$lot, $proprietaire]) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold" onclick="return confirm('{{ __('Withdraw Owner') }} ?');">{{ __('Withdraw') }}</button>
                                                </form>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="px-4 py-3 text-sm text-gray-500">{{ __('xxxxxxxxxxxxx') }}Ce lot n'est associé à aucun propriétaire.</li>
                                    @endforelse
                                    <li class="px-4 py-3 bg-gray-50 font-bold flex justify-between">
                                        <span>Total</span>
                                        <span>{{ number_format($lot->proprietaires->sum('pivot.pourcentage_possession'), 2, ',', ' ') }} %</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
```
