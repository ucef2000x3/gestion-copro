<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Residences Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    <!-- En-tête de la section -->
                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold leading-6 text-gray-900">{{ __('Residence') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">{{ __('Residences List') }}</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            {{-- On garde la policy de la classe originale pour l'instant --}}
                            @can('create', App\Models\Residence::class)
                                <a href="{{ route('residences.create') }}"
                                   class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                    {{ __('Add Residence') }}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <!-- Messages de session -->
                    @if (session('success'))
                        <div
                            class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">{{ session('error') }}</div>
                    @endif

                    <!-- Tableau -->
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                            {{ __('Residence Name') }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Condominium') }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('City') }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Status') }}
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">{{ __('Actions') }}</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    {{-- La boucle utilise maintenant les variables corrigées --}}
                                    @php
                                        //dd($residences->first());
                                    @endphp
                                    @forelse ($residences as $residence)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $residence->nom_residence }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $residence->copropriete->nom_copropriete ?? 'N/A' }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $residence->ville }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                @if($residence->statut)
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ __('Active') }}</span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{ __('Inactive') }}</span>
                                                @endif
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                <div class="flex items-center justify-end space-x-4">
                                                    {{-- Les routes utilisent maintenant le bon nom et passent la bonne variable --}}
                                                    @can('update', $residence)
                                                        <a href="{{ route('residences.edit', $residence) }}"
                                                           class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                                    @endcan
                                                    @can('delete', $residence)
                                                        <form action="{{ route('residences.destroy', $residence) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('{{ __('Sure') }} ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="text-red-600 hover:text-red-900">{{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-500">
                                                {{ __('xxxxxxxx') }}Aucun bâtiment trouvé.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Liens de pagination -->
                    <div class="mt-4">
                        {{ $residences->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
