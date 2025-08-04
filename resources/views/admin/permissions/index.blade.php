<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Gestion des Permissions') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold">Permissions</h1>
                            <p class="mt-2 text-sm text-gray-700">Liste des permissions.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            @can('create', App\Models\Permission::class)
                                <a href="{{ route('permissions.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Ajouter une permission</a>
                            @endcan
                        </div>
                    </div>
                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead><tr><th>Clé</th><th>Nom</th><th><span class="sr-only">Actions</span></th></tr></thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse ($permissions as $permission)
                            <tr>
                                <td class="font-mono text-gray-500">{{ $permission->cle }}</td>
                                <td>{{ $permission->getTranslated('nom_permission') }}</td>
                                <td>
                                    <div class="flex items-center justify-end space-x-4">
                                        @can('update', $permission)
                                            <a href="{{ route('permissions.edit', $permission) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                        @endcan
                                        @can('delete', $permission)
                                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Sûr ?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4">Aucune permission trouvée.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $permissions->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
