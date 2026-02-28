<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <!-- Dashboard Link -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Menu Déroulant "Structure" -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('Structure') }}</div>
                                    <div class="ml-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                @can('viewAny', App\Models\Syndic::class)
                                    <x-dropdown-link :href="route('syndics.index')"> {{ __('Syndics') }} </x-dropdown-link>
                                @endcan
                                @can('viewAny', App\Models\Copropriete::class)
                                    <x-dropdown-link :href="route('coproprietes.index')"> {{ __('Copropriétés') }} </x-dropdown-link>
                                @endcan
                                @can('viewAny', App\Models\Residence::class)
                                    <x-dropdown-link :href="route('residences.index')"> {{ __('Résidences') }} </x-dropdown-link>
                                @endcan
                                @can('viewAny', App\Models\Lot::class)
                                    <x-dropdown-link :href="route('lots.index')"> {{ __('Lots') }} </x-dropdown-link>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Menu Déroulant "Tiers" -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('Tiers') }}</div>
                                    <div class="ml-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                @can('viewAny', App\Models\Proprietaire::class)
                                    <x-dropdown-link :href="route('proprietaires.index')"> {{ __('Propriétaires') }} </x-dropdown-link>
                                @endcan
                                @can('viewAny', App\Models\Fournisseur::class)
                                    <x-dropdown-link :href="route('fournisseurs.index')"> {{ __('Fournisseurs') }} </x-dropdown-link>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Menu Déroulant "Comptabilité" -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('Comptabilité') }}</div>
                                    <div class="ml-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                @can('viewAny', App\Models\Exercice::class)
                                    <x-dropdown-link :href="route('exercices.index')"> {{ __('Exercices') }} </x-dropdown-link>
                                @endcan
                                @can('viewAny', App\Models\Facture::class)
                                    <x-dropdown-link :href="route('factures.index')"> {{ __('Factures') }} </x-dropdown-link>
                                @endcan
                                @can('viewAny', App\Models\AppelDeFonds::class)
                                    <x-dropdown-link :href="route('appels-de-fonds.index')"> {{ __('Appels de Fonds') }} </x-dropdown-link>
                                @endcan
                                @can('viewAny', App\Models\ReglementProprietaire::class)
                                    <x-dropdown-link :href="route('reglements-proprietaires.index')"> {{ __('Règlements') }} </x-dropdown-link>
                                @endcan
                                @can('viewAny', App\Models\OperationDiverse::class)
                                    <x-dropdown-link :href="route('operations-diverses.index')"> {{ __('Opérations Diverses') }} </x-dropdown-link>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')"> {{ __('Profile') }} </x-dropdown-link>

                        <!-- Lignes de séparation et titres pour le menu déroulant -->
                        <div class="border-t border-gray-200"></div>
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Paramètres') }}
                        </div>

                        @can('viewAny', App\Models\User::class)
                            <x-dropdown-link :href="route('users.index')"> {{ __('Utilisateurs') }} </x-dropdown-link>
                        @endcan

                        {{-- ============================================= --}}
                        {{-- == CORRECTION DE LA DIRECTIVE @if MANQUANTE == --}}
                        {{-- ============================================= --}}
                        @if(auth()->user()->isSuperAdmin())
                            <x-dropdown-link :href="route('roles.index')"> {{ __('Rôles & Permissions') }} </x-dropdown-link>
                        @endif

                        @can('viewAny', App\Models\TypeDePoste::class)
                            <x-dropdown-link :href="route('types-de-poste.index')"> {{ __('Catalogue de Postes') }} </x-dropdown-link>
                        @endcan

                        <div class="border-t border-gray-200"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (menu mobile) -->
            {{-- Ici se trouve le code du menu hamburger pour les petits écrans --}}
        </div>
    </div>
</nav>
