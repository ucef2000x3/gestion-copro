<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Langue;
use App\Models\Syndic;
use App\Models\Copropriete;
use App\Models\Residence;
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
        $tables = [
            'lot_proprietaire', 'affectations', 'utilisateur_role', 'role_has_permission',
            'permissions', 'roles', 'proprietaires', 'lots', 'residences', 'coproprietes',
            'syndics', 'users', 'langues'
        ];
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
            // GESTION DES COPROPRIÉTÉS (entités globales)
            ['cle' => 'copropriete:voir', 'nom_permission' => ['fr' => 'Voir Copropriétés', 'en' => 'View Condominiums']],
            ['cle' => 'copropriete:creer', 'nom_permission' => ['fr' => 'Créer Copropriété', 'en' => 'Create Condominium']],
            ['cle' => 'copropriete:modifier', 'nom_permission' => ['fr' => 'Modifier Copropriété', 'en' => 'Edit Condominium']],
            ['cle' => 'copropriete:supprimer', 'nom_permission' => ['fr' => 'Supprimer Copropriété', 'en' => 'Delete Condominium']],
            // GESTION DES RÉSIDENCES (bâtiments)
            ['cle' => 'residence:voir', 'nom_permission' => ['fr' => 'Voir Résidences/Bâtiments', 'en' => 'View Residences/Buildings']],
            ['cle' => 'residence:creer', 'nom_permission' => ['fr' => 'Créer Résidence/Bâtiment', 'en' => 'Create Residence/Building']],
            ['cle' => 'residence:modifier', 'nom_permission' => ['fr' => 'Modifier Résidence/Bâtiment', 'en' => 'Edit Residence/Building']],
            ['cle' => 'residence:supprimer', 'nom_permission' => ['fr' => 'Supprimer Résidence/Bâtiment', 'en' => 'Delete Residence/Building']],
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
        foreach ($permissions as $permissionData) { Permission::create($permissionData); }
        $this->command->info('Permissions de base créées.');

        // CORRECTION : Utilisation de updateOrCreate pour la compatibilité avec PostgreSQL JSON
        $superAdminRole = Role::updateOrCreate(['nom_role->fr' => 'Super Administrateur'], ['nom_role' => ['fr' => 'Super Administrateur', 'en' => 'Super Administrator']]);
        $gestionnaireRole = Role::updateOrCreate(['nom_role->fr' => 'Gestionnaire'], ['nom_role' => ['fr' => 'Gestionnaire', 'en' => 'Manager']]);
        $proprietaireRole = Role::updateOrCreate(['nom_role->fr' => 'Propriétaire'], ['nom_role' => ['fr' => 'Propriétaire', 'en' => 'Owner']]);
        $this->command->info('Rôles de base créés.');

        $superAdminRole->permissions()->sync(Permission::pluck('id_permission'));

        // --------------------------------------------------------------------
        // 3. CRÉATION DES DONNÉES MÉTIER DE TEST
        // --------------------------------------------------------------------
        $syndicA = Syndic::create(['nom_entreprise' => 'Syndic A - Paris Gérance']);
        $syndicB = Syndic::create(['nom_entreprise' => 'Syndic B - Immo Sud']);
        $this->command->info('Syndics de test créés.');

        $coproParc = Copropriete::create(['nom_copropriete' => 'Copropriété du Grand Parc', 'id_syndic' => $syndicA->id_syndic]);
        $coproLac = Copropriete::create(['nom_copropriete' => 'Copropriété du Lac', 'id_syndic' => $syndicB->id_syndic]);
        $this->command->info('Copropriétés de test créées.');

        $residenceTilleuls = Residence::create(['nom_residence' => 'Les Tilleuls (Bât. A)', 'id_copropriete' => $coproParc->id_copropriete]);
        $residenceChenes = Residence::create(['nom_residence' => 'Les Chênes (Bât. B)', 'id_copropriete' => $coproParc->id_copropriete]);
        $residenceNenuphars = Residence::create(['nom_residence' => 'Les Nénuphars', 'id_copropriete' => $coproLac->id_copropriete]);
        $this->command->info('Résidences (bâtiments) de test créées.');

        $lotA101 = Lot::create(['id_residence' => $residenceTilleuls->id_residence, 'numero_lot' => 'A101', 'nombre_tantiemes' => 120]);
        $lotB205 = Lot::create(['id_residence' => $residenceChenes->id_residence, 'numero_lot' => 'B205', 'nombre_tantiemes' => 150]);
        $lotLac5 = Lot::create(['id_residence' => $residenceNenuphars->id_residence, 'numero_lot' => 'Appt 5', 'nombre_tantiemes' => 95]);
        $this->command->info('Lots de test créés.');

        // --------------------------------------------------------------------
        // 4. CRÉATION DES UTILISATEURS ET PROPRIÉTAIRES DE TEST
        // --------------------------------------------------------------------
        $userAdmin = User::factory()->create(['name' => 'Super Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'is_super_admin' => true]);

        $proprioDupont = Proprietaire::create(['nom' => 'Dupont', 'prenom' => 'Paul', 'email' => 'dupont@example.com']);
        $proprioDurand = Proprietaire::create(['nom' => 'Durand', 'prenom' => 'Marie', 'email' => 'durand@example.com']);

        $lotA101->proprietaires()->sync([$proprioDupont->id_proprietaire => ['pourcentage_possession' => 100]]);
        $lotB205->proprietaires()->sync([$proprioDupont->id_proprietaire => ['pourcentage_possession' => 100]]);
        $lotLac5->proprietaires()->sync([$proprioDurand->id_proprietaire => ['pourcentage_possession' => 50], $proprioDupont->id_proprietaire => ['pourcentage_possession' => 50]]);
        $this->command->info('Propriétaires de test créés et liés aux lots.');

        // --------------------------------------------------------------------
        // 5. ASSIGNATION DES DROITS AUX UTILISATEURS DE TEST
        // --------------------------------------------------------------------
        $userGlobal = User::factory()->create(['name' => 'Gaston Global', 'email' => 'global@example.com', 'password' => Hash::make('password')]);
        $gestionnairePermissions = Permission::whereIn('cle', ['syndic:voir', 'copropriete:voir', 'residence:voir', 'lot:voir', 'proprietaire:voir'])->pluck('id_permission');
        $gestionnaireRole->permissions()->sync($gestionnairePermissions);
        $userGlobal->roles()->sync([$gestionnaireRole->id_role]);
        $this->command->info('Utilisateur Gestionnaire Global créé (droits de lecture seule).');

        $userSpecifique = User::factory()->create(['name' => 'Gisele Spécifique (Copro Parc)', 'email' => 'specifique@example.com', 'password' => Hash::make('password')]);
        $userSpecifique->affectations()->create(['id_role' => $gestionnaireRole->id_role, 'affectable_type' => Copropriete::class, 'affectable_id' => $coproParc->id_copropriete]);
        $this->command->info('Utilisateur Gestionnaire Spécifique créé (droits de lecture sur Copro Parc).');
    }
}
