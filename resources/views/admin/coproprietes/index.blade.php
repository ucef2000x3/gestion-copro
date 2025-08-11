<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Condominiums Management') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold leading-6 text-gray-900">{{ __('Condominiums') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">{{ __('Condominiums List') }}</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            @can('create', App\Models\Copropriete::class)
                                <a href="{{ route('coproprietes.create') }}"
                                   class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">{{ __('Add Condominium') }}</a>
                            @endcan
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                            {{ __('Condominium Name') }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Syndic') }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('My Role') }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Currency') }}
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Statut') }}
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            <span class="sr-only">{{ __('Actions') }}</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse ($coproprietes as $copropriete)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $copropriete->nom_copropriete }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $copropriete->syndic->nom_entreprise ?? 'N/A' }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                @php
                                                    // On appelle notre nouvelle méthode helper
                                                    $contextualRole = auth()->user()->getRoleFor($copropriete);
                                                @endphp

                                                @if ($contextualRole)
                                                    {{-- On affiche le nom du rôle trouvé --}}
                                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                            {{ $contextualRole->getTranslated('nom_role') }}
                        </span>
                                                @else
                                                    <span class="text-gray-400">N/A ({{ __('Global Access') }})</span>
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $copropriete->devise->code ?? 'N/A' }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                @if ($copropriete->statut)
                                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                        {{ __('Active') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                                        {{ __('Inactive') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                <div class="flex items-center justify-end space-x-4">
                                                    @can('update', $copropriete)
                                                        <a href="{{ route('coproprietes.edit', $copropriete) }}"
                                                           class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                                    @endcan
                                                    @can('delete', $copropriete)
                                                        <form action="{{ route('coproprietes.destroy', $copropriete) }}"
                                                              method="POST" onsubmit="return confirm('{{ __('Sure ?') }}');">
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
                                            <td colspan="3"
                                                class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-500">
                                                {{ __('No Condominium Found') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Note: La pagination doit être gérée différemment. On va la commenter pour l'instant. --}}
                    {{-- <div class="mt-4">{{ $coproprietes->links() }}</div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
