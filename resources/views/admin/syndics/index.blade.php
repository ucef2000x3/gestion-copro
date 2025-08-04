<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Syndic Management') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold leading-6 text-gray-900">{{ __('Syndics') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">{{ __('List of all syndics') }}.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            @can('create', App\Models\Syndic::class)
                                <a href="{{ route('syndics.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">{{ __('Add Syndic') }}</a>
                            @endcan
                        </div>
                    </div>
                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
                    @if (session('error'))
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th>{{ __('Syndic Name') }}</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th><span class="sr-only">{{ __('Actions') }}</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse ($syndics as $syndic)
                            <tr>
                                <td>{{ $syndic->nom_entreprise }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    @if ($syndic->statut)
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                            {{ __('Active') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                            {{ __('Inactive') }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $syndic->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="flex items-center justify-end space-x-4">
                                        @can('update', $syndic)
                                            <a href="{{ route('syndics.edit', $syndic) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                        @endcan
                                        @can('delete', $syndic)
                                            <form action="{{ route('syndics.destroy', $syndic) }}" method="POST" onsubmit="return confirm('{{ __('Sure ?') }}');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Delete') }}</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4">{{ __('No Syndic found') }}.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $syndics->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
