<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Gestion des Utilisateurs') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto"><h1 class="text-xl font-semibold">Utilisateurs</h1></div>
                    </div>
                    @if (session('success'))<div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>@endif
                    @if (session('error'))<div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">{{ session('error') }}</div>@endif
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead><tr><th>Nom</th><th>Email</th><th>Rôles</th><th><span class="sr-only">Actions</span></th></tr></thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles->map(fn($role) => $role->getTranslated('nom_role'))->implode(', ') }}</td>
                                <td>
                                    <div class="flex items-center justify-end space-x-4">
                                        @can('update', $user)
                                            <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                        @endcan
                                        @can('delete', $user)
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Sûr ?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4">Aucun utilisateur trouvé.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
