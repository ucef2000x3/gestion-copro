<?php

namespace App\Providers;

// Models
use App\Models\User;
use App\Models\Syndic;
use App\Models\Copropriete;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Residence;
use App\Models\Lot;
use App\Models\Proprietaire;

// Policies
use App\Policies\SyndicPolicy;
use App\Policies\CoproprietePolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\UserPolicy;
use App\Policies\ResidencePolicy;
use App\Policies\LotPolicy;
use App\Policies\ProprietairePolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// =========================================================
// == L'IMPORTATION MANQUANTE EST ICI ==
// =========================================================
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Syndic::class => SyndicPolicy::class,
        Copropriete::class => CoproprietePolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        User::class => UserPolicy::class,
        Residence::class => ResidencePolicy::class,
        Lot::class => LotPolicy::class,
        Proprietaire::class => ProprietairePolicy::class,
        // C'est ici que vous ajouterez vos futures policies
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Définition du passe-droit Super Admin
        Gate::before(function (User $user, string $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
    }
}
