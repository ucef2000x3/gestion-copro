<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Langue;
use App\Models\Syndic;
use App\Models\Residence;
use App\Models\Copropriete;
use App\Models\Lot;
use App\Models\Proprietaire;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --------------------------------------------------------------------
        // 1. RÉINITIALISATION PROPRE DE LA BASE DE DONNÉES
        // --------------------------------------------------------------------
        Schema::disableForeignKeyConstraints();
        $tables = ['lot_proprietaire', 'affectations', 'utilisateur_role', 'role_has_permission', 'permissions', 'roles', 'proprietaires', 'lots', 'coproprietes', 'residences', 'syndics', 'users', 'langues'];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        Schema::enableForeignKeyConstraints();
        $this->command->info('Toutes les tables ont été vidées.');


        // --------------------------------------------------------------------
        // 2. CRÉATION DES DONNÉES DE CONFIGURATION DE BASE
        // --------------------------------------------------------------------
        Langue::create(['code_langue' => 'fr', 'nom' => 'Français']);
        Langue::create(['code_langue' => 'en', 'nom' => 'English']);

        $permissions = [
            // GESTION DES SYNDICS
            ['cle' => 'syndic:voir', 'nom_permission' => ['fr' => 'Voir Syndics', 'en' => 'View Syndics']],
            ['cle' => 'syndic:creer', 'nom_permission' => ['fr' => 'Créer Syndic', 'en' => 'Create Syndic']],
            ['cle' => 'syndic:modifier', 'nom_permission' => ['fr' => 'Modifier Syndic', 'en' => 'Edit Syndic']],
            ['cle' => 'syndic:supprimer', 'nom_permission' => ['fr' => 'Supprimer Syndic', 'en' => 'Delete Syndic']],
            // GESTION DES RÉSIDENCES
            ['cle' => 'residence:voir', 'nom_permission' => ['fr' => 'Voir Résidences', 'en' => 'View Residences']],
            ['cle' => 'residence:creer', 'nom_permission' => ['fr' => 'Créer Résidence', 'en' => 'Create Residence']],
            ['cle' => 'residence:modifier', 'nom_permission' => ['fr' => 'Modifier Résidence', 'en' => 'Edit Residence']],
            ['cle' => 'residence:supprimer', 'nom_permission' => ['fr' => 'Supprimer Résidence', 'en' => 'Delete Residence']],
            // GESTION DES COPROPRIÉTÉS
            ['cle' => 'copropriete:voir', 'nom_permission' => ['fr' => 'Voir Copropriétés', 'en' => 'View Condominiums']],
            ['cle' => 'copropriete:creer', 'nom_permission' => ['fr' => 'Créer Copropriété', 'en' => 'Create Condominium']],
            ['cle' => 'copropriete:modifier', 'nom_permission' => ['fr' => 'Modifier Copropriété', 'en' => 'Edit Condominium']],
            ['cle' => 'copropriete:supprimer', 'nom_permission' => ['fr' => 'Supprimer Copropriété', 'en' => 'Delete Condominium']],
            // GESTION DES LOTS
            ['cle' => 'lot:voir', 'nom_permission' => ['fr' => 'Voir Lots', 'en' => 'View Lots']],
            ['cle' => 'lot:creer', 'nom_permission' => ['fr' => 'Créer Lot', 'en' => 'Create Lot']],
            ['cle' => 'lot:modifier', 'nom_permission' => ['fr' => 'Modifier Lot', 'en' => 'Edit Lot']],
            ['cle' => 'lot:supprimer', 'nom_permission' => ['fr' => 'Supprimer Lot', 'en' => 'Delete Lot']],
            // GESTION DES PROPRIETAIRES
            ['cle' => 'proprietaire:voir', 'nom_permission' => ['fr' => 'Voir Propriétaires', 'en' => 'View Owners']],
            ['cle' => 'proprietaire:creer', 'nom_permission' => ['fr' => 'Créer Propriétaire', 'en' => 'Create Owner']],
            ['cle' => 'proprietaire:modifier', 'nom_permission' => ['fr' => 'Modifier Propriétaire', 'en' => 'Edit Owner']],
            ['cle' => 'proprietaire:supprimer', 'nom_permission' => ['fr' => 'Supprimer Propriétaire', 'en' => 'Delete Owner']],
            // GESTION DES ACCÈS
            ['cle' => 'role:voir', 'nom_permission' => ['fr' => 'Voir Rôles', 'en' => 'View Roles']],
            ['cle' => 'role:modifier', 'nom_permission' => ['fr' => 'Modifier Rôles & Permissions', 'en' => 'Edit Roles & Permissions']],
            ['cle' => 'utilisateur:voir', 'nom_permission' => ['fr' => 'Voir Utilisateurs', 'en' => 'View Users']],
            ['cle' => 'utilisateur:modifier', 'nom_permission' => ['fr' => 'Modifier Utilisateurs & Rôles', 'en' => 'Edit Users & Roles']],
        ];
        foreach ($permissions as $permission) { Permission::create($permission); }
        $this->command->info('Permissions de base créées.');

        $superAdminRole = Role::create(['nom_role' => ['fr' => 'Super Administrateur', 'en' => 'Super Administrator']]);
        $gestionnaireRole = Role::create(['nom_role' => ['fr' => 'Gestionnaire', 'en' => 'Manager']]);
        $proprietaireRole = Role::create(['nom_role' => ['fr' => 'Propriétaire', 'en' => 'Owner']]);
        $this->command->info('Rôles de base créés.');

        $superAdminRole->permissions()->sync(Permission::pluck('id_permission'));
        $this->command->info('Permissions assignées au Super Administrateur.');

        // --------------------------------------------------------------------
        // 3. CRÉATION DES DONNÉES MÉTIER DE TEST
        // --------------------------------------------------------------------
        $syndicA = Syndic::create(['nom_entreprise' => 'Syndic A - Paris Gérance']);
        $syndicB = Syndic::create(['nom_entreprise' => 'Syndic B - Immo Sud']);
        $resParc = Residence::create(['nom_residence' => 'Résidence du Parc', 'id_syndic' => $syndicA->id_syndic]);
        $resLac = Residence::create(['nom_residence' => 'Résidence du Lac', 'id_syndic' => $syndicB->id_syndic]);
        $coproParcBatA = Copropriete::create(['nom_copropriete' => 'Bâtiment A - Le Parc', 'ville' => 'Paris', 'id_residence' => $resParc->id_residence]);
        $coproLac = Copropriete::create(['nom_copropriete' => 'Les Nénuphars - Le Lac', 'ville' => 'Lyon', 'id_residence' => $resLac->id_residence]);
        $lotA101 = Lot::create(['id_copropriete' => $coproParcBatA->id_copropriete, 'numero_lot' => 'A101', 'nombre_tantiemes' => 120]);
        $lotCave12 = Lot::create(['id_copropriete' => $coproParcBatA->id_copropriete, 'numero_lot' => 'Cave 12', 'nombre_tantiemes' => 5]);
        $lotLac5 = Lot::create(['id_copropriete' => $coproLac->id_copropriete, 'numero_lot' => 'Appt 5', 'nombre_tantiemes' => 95]);
        $this->command->info('Données métier (Syndics, Résidences, Copropriétés, Lots) créées.');

        // --------------------------------------------------------------------
        // 4. CRÉATION DES UTILISATEURS ET PROPRIÉTAIRES DE TEST
        // --------------------------------------------------------------------
        // -- SUPER ADMIN --
        $userAdmin = User::factory()->create(['name' => 'Super Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'is_super_admin' => true]);
        $this->command->info('Utilisateur Super Admin créé (admin@example.com / password).');

        // -- GESTIONNAIRE SPÉCIFIQUE (pour Syndic A) --
        $userGestionnaireA = User::factory()->create(['name' => 'Gisele Spécifique (Syndic A)', 'email' => 'gestion-a@example.com', 'password' => Hash::make('password')]);
        // On lui donne le rôle "Gestionnaire" sur le périmètre du Syndic A.
        $gestionnairePermissions = Permission::where('cle', 'like', '%:voir')
            ->orWhere('cle', 'like', '%:modifier')
            ->orWhere('cle', 'like', '%:creer')
            ->pluck('id_permission');
        $gestionnaireRole->permissions()->sync($gestionnairePermissions);
        $userGestionnaireA->affectations()->create(['id_role' => $gestionnaireRole->id_role, 'affectable_type' => Syndic::class, 'affectable_id' => $syndicA->id_syndic]);
        $this->command->info('Utilisateur Gestionnaire Spécifique A créé (gestion-a@example.com / password).');

        // -- GESTIONNAIRE TRÈS RESTREINT (pour Résidence du Lac UNIQUEMENT) --
        $userGestionnaireLac = User::factory()->create(['name' => 'Gérard Restreint (Rés. Lac)', 'email' => 'gestion-lac@example.com', 'password' => Hash::make('password')]);
        $roleRestreint = Role::create(['nom_role' => ['fr' => 'Gestionnaire Résidence Lac', 'en' => 'Manager Lake Residence']]);
        $roleRestreint->permissions()->sync(Permission::where('cle', 'like', 'lot:%')->pluck('id_permission'));
        $userGestionnaireLac->affectations()->create(['id_role' => $roleRestreint->id_role, 'affectable_type' => Residence::class, 'affectable_id' => $resLac->id_residence]);
        $this->command->info('Utilisateur Gestionnaire Restreint créé (gestion-lac@example.com / password).');

        // -- PROPRIÉTAIRES --
        $userProprioDupont = User::factory()->create(['name' => 'Paul Dupont', 'email' => 'dupont@example.com', 'password' => Hash::make('password')]);
        $userProprioDurand = User::factory()->create(['name' => 'Marie Durand', 'email' => 'durand@example.com', 'password' => Hash::make('password')]);

        $proprioDupont = Proprietaire::create(['nom' => 'Dupont', 'prenom' => 'Paul', 'email' => 'dupont@example.com', 'id_utilisateur' => $userProprioDupont->id]);
        $proprioDurand = Proprietaire::create(['nom' => 'Durand', 'prenom' => 'Marie', 'email' => 'durand@example.com', 'id_utilisateur' => $userProprioDurand->id]);

        // On lie les propriétaires aux lots
        $lotA101->proprietaires()->sync([$proprioDupont->id_proprietaire]);
        $lotCave12->proprietaires()->sync([$proprioDupont->id_proprietaire]);
        $lotLac5->proprietaires()->sync([$proprioDurand->id_proprietaire]);
        $this->command->info('Propriétaires et Utilisateurs associés créés.');
    }
}
