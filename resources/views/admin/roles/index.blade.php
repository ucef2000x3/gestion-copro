<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Gestion des Rôles') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold">Rôles</h1>
                            <p class="mt-2 text-sm text-gray-700">Liste des rôles.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            @can('create', App\Models\Role::class)
                                <a href="{{ route('roles.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Ajouter un rôle</a>
                            @endcan
                        </div>
                    </div>
                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead><tr><th>Nom</th><th><span class="sr-only">Actions</span></th></tr></thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse ($roles as $role)
                            <tr>
                                <td>{{ $role->getTranslated('nom_role') }}</td>
                                <td>
                                    <div class="flex items-center justify-end space-x-4">
                                        @can('update', $role)
                                            <a href="{{ route('roles.edit', $role) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                        @endcan
                                        @can('delete', $role)
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Sûr ?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center py-4">Aucun rôle trouvé.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $roles->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
