<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- == MENU GESTION == -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('Gestion') }}</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                @can('viewAny', App\Models\Syndic::class)<x-dropdown-link :href="route('syndics.index')">{{ __('Syndics') }}</x-dropdown-link>@endcan
                                @can('viewAny', App\Models\Copropriete::class)<x-dropdown-link :href="route('coproprietes.index')">{{ __('Copropriétés') }}</x-dropdown-link>@endcan
                                @can('viewAny', App\Models\Residence::class)<x-dropdown-link :href="route('residences.index')">{{ __('Résidences (Bâtiments)') }}</x-dropdown-link>@endcan
                                @can('viewAny', App\Models\Lot::class)<x-dropdown-link :href="route('lots.index')">{{ __('Lots') }}</x-dropdown-link>@endcan
                                @can('viewAny', App\Models\Proprietaire::class)<x-dropdown-link :href="route('proprietaires.index')">{{ __('Propriétaires') }}</x-dropdown-link>@endcan
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- == MENU FINANCE == -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('Finance') }}</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                @can('viewAny', App\Models\ExerciceComptable::class)<x-dropdown-link :href="route('exercices.index')">{{ __('Exercices Comptables') }}</x-dropdown-link>@endcan
                                @can('viewAny', App\Models\TypeDePoste::class)<x-dropdown-link :href="route('types-de-poste.index')">{{ __('Catalogue des Postes') }}</x-dropdown-link>@endcan
                                @can('viewAny', App\Models\Fournisseur::class)<x-dropdown-link :href="route('fournisseurs.index')">{{ __('Fournisseurs') }}</x-dropdown-link>@endcan
                                @can('viewAny', App\Models\Facture::class)<x-dropdown-link :href="route('factures.index')">{{ __('Factures') }}</x-dropdown-link>@endcan
                                @can('viewAny', App\Models\AppelDeFonds::class)<x-dropdown-link :href="route('appels-de-fonds.index')">{{ __('Appels de Fonds') }}</x-dropdown-link>@endcan
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- == MENU ADMINISTRATION == -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('Administration') }}</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                @can('viewAny', App\Models\User::class)<x-dropdown-link :href="route('users.index')">{{ __('Utilisateurs') }}</x-dropdown-link>@endcan
                                @can('viewAny', App\Models\Role::class)<x-dropdown-link :href="route('roles.index')">{{ __('Rôles') }}</x-dropdown-link>@endcan
                                @can('viewAny', App\Models\Permission::class)<x-dropdown-link :href="route('permissions.index')">{{ __('Permissions') }}</x-dropdown-link>@endcan
                                {{-- @can('viewAny', App\Models\Devise::class)<x-dropdown-link :href="route('devises.index')">{{ __('Devises') }}</x-dropdown-link>@endcan --}}
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}"><@csrf<x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link></form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>

            <h3 class="px-4 pt-4 text-xs font-semibold text-gray-400 uppercase">Gestion</h3>
            @can('viewAny', App\Models\Syndic::class)<x-responsive-nav-link :href="route('syndics.index')">{{ __('Syndics') }}</x-responsive-nav-link>@endcan
            @can('viewAny', App\Models\Copropriete::class)<x-responsive-nav-link :href="route('coproprietes.index')">{{ __('Copropriétés') }}</x-responsive-nav-link>@endcan
            @can('viewAny', App\Models\Residence::class)<x-responsive-nav-link :href="route('residences.index')">{{ __('Résidences (Bâtiments)') }}</x-responsive-nav-link>@endcan
            @can('viewAny', App\Models\Lot::class)<x-responsive-nav-link :href="route('lots.index')">{{ __('Lots') }}</x-responsive-nav-link>@endcan
            @can('viewAny', App\Models\Proprietaire::class)<x-responsive-nav-link :href="route('proprietaires.index')">{{ __('Propriétaires') }}</x-responsive-nav-link>@endcan

            <h3 class="px-4 pt-4 text-xs font-semibold text-gray-400 uppercase">Finance</h3>
            @can('viewAny', App\Models\ExerciceComptable::class)<x-responsive-nav-link :href="route('exercices.index')">{{ __('Exercices Comptables') }}</x-responsive-nav-link>@endcan
            @can('viewAny', App\Models\TypeDePoste::class)<x-responsive-nav-link :href="route('types-de-poste.index')">{{ __('Catalogue des Postes') }}</x-responsive-nav-link>@endcan
            @can('viewAny', App\Models\Fournisseur::class)<x-responsive-nav-link :href="route('fournisseurs.index')">{{ __('Fournisseurs') }}</x-responsive-nav-link>@endcan
            @can('viewAny', App\Models\Facture::class)<x-responsive-nav-link :href="route('factures.index')">{{ __('Factures') }}</x-responsive-nav-link>@endcan
            @can('viewAny', App\Models\AppelDeFonds::class)<x-responsive-nav-link :href="route('appels-de-fonds.index')">{{ __('Appels de Fonds') }}</x-responsive-nav-link>@endcan

            <h3 class="px-4 pt-4 text-xs font-semibold text-gray-400 uppercase">Administration</h3>
            @can('viewAny', App\Models\User::class)<x-responsive-nav-link :href="route('users.index')">{{ __('Utilisateurs') }}</x-responsive-nav-link>@endcan
            @can('viewAny', App\Models\Role::class)<x-responsive-nav-link :href="route('roles.index')">{{ __('Rôles') }}</x-responsive-nav-link>@endcan
            @can('viewAny', App\Models\Permission::class)<x-responsive-nav-link :href="route('permissions.index')">{{ __('Permissions') }}</x-responsive-nav-link>@endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}"><@csrf<x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link></form>
            </div>
        </div>
    </div>
</nav>
