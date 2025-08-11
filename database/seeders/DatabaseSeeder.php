<?php

namespace Database\Seeders;

use App\Enums\StatutExercice;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Langue;
use App\Models\Syndic;
use App\Models\Copropriete;
use App\Models\Residence;
use App\Models\Lot;
use App\Models\Proprietaire;
use App\Models\ExerciceComptable;
use App\Models\TypeDePoste;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. RÉINITIALISATION PROPRE
        Schema::disableForeignKeyConstraints();
        $tables = [
            'lot_proprietaire', 'affectations', 'utilisateur_role', 'role_has_permission', 'permissions',
            'roles', 'proprietaires', 'lots', 'residences', 'coproprietes', 'syndics',
            'users', 'langues', 'exercices_comptables', 'types_de_poste', 'budget_postes', 'factures', 'fournisseurs'
        ];
        foreach ($tables as $table) { DB::table($table)->truncate(); }
        Schema::enableForeignKeyConstraints();
        $this->command->info('Toutes les tables ont été vidées.');

        // 2. DONNÉES DE CONFIGURATION DE BASE
        Langue::create(['code_langue' => 'fr', 'nom' => 'Français']);

        $permissions = $this->createPermissions();
        foreach ($permissions as $permissionData) { Permission::create($permissionData); }
        $this->command->info('Permissions de base créées.');

        $superAdminRole = Role::create(['nom_role' => ['fr' => 'Super Administrateur']]);
        $gestionnaireRole = Role::create(['nom_role' => ['fr' => 'Gestionnaire']]);
        $proprietaireRole = Role::create(['nom_role' => ['fr' => 'Propriétaire']]);
        $superAdminRole->permissions()->sync(Permission::pluck('id_permission'));
        $this->command->info('Rôles de base créés.');

        // 3. CRÉATION MASSIVE DE DONNÉES MÉTIER
        $this->command->info('Création des données de test...');

        // Création de 5 Syndics
        $syndics = Syndic::factory(5)->create();
        $this->command->info('5 Syndics créés.');

        // Création de 10 Copropriétés réparties aléatoirement
        $coproprietes = Copropriete::factory(10)->make()->each(function ($copro) use ($syndics) {
            $copro->syndic()->associate($syndics->random());
            $copro->save();
        });
        $this->command->info('10 Copropriétés créées.');

        // Pour chaque copropriété, créer entre 1 et 4 Résidences (bâtiments)
        foreach ($coproprietes as $copro) {
            $residences = Residence::factory(rand(1, 4))->make()->each(function ($residence) use ($copro) {
                $residence->copropriete()->associate($copro);
                $residence->save();

                // Pour chaque résidence, créer entre 10 et 50 Lots
                Lot::factory(rand(10, 50))->make()->each(function ($lot) use ($residence) {
                    $lot->residence()->associate($residence);
                    $lot->save();
                });
            });
        }
        $this->command->info('Résidences et Lots créés en masse.');

        // Création de 100 Propriétaires
        $proprietaires = Proprietaire::factory(100)->create();
        $this->command->info('100 Propriétaires créés.');

        // Lier des propriétaires à des lots au hasard
        $lots = Lot::all();
        foreach ($lots as $lot) {
            $lot->proprietaires()->sync($proprietaires->random(rand(1, 2))->pluck('id_proprietaire')->toArray());
        }
        $this->command->info('Propriétaires liés aux lots.');

        // 4. DONNÉES FINANCIÈRES
        foreach ($coproprietes as $copro) {
            $exercice = ExerciceComptable::create([
                'id_copropriete' => $copro->id_copropriete,
                'libelle' => 'Exercice 2025 - ' . $copro->nom_copropriete,
                'date_debut' => '2025-01-01',
                'date_fin' => '2025-12-31',
                'statut' => StatutExercice::Ouvert, // Utilisation de l'Enum
            ]);

            $posteAssurance = TypeDePoste::create(['id_copropriete' => $copro->id_copropriete, 'libelle' => 'Assurance Immeuble']);
            $posteEau = TypeDePoste::create(['id_copropriete' => $copro->id_copropriete, 'libelle' => 'Eau Froide']);

            $exercice->budgetPostes()->create(['id_type_poste' => $posteAssurance->id_type_poste, 'montant_previsionnel' => rand(5000, 15000)]);
            $exercice->budgetPostes()->create(['id_type_poste' => $posteEau->id_type_poste, 'montant_previsionnel' => rand(2000, 8000)]);
        }
        $this->command->info('Données financières de base créées pour chaque copropriété.');

        // 5. UTILISATEURS DE TEST
        $userAdmin = User::factory()->create(['name' => 'Super Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'is_super_admin' => true]);

        $userGestionnaire = User::factory()->create(['name' => 'Gestionnaire Global', 'email' => 'gestion@example.com', 'password' => Hash::make('password')]);
        $gestionnairePermissions = Permission::where('cle', 'not like', 'role:%')->pluck('id_permission');
        $gestionnaireRole->permissions()->sync($gestionnairePermissions);
        $userGestionnaire->roles()->sync([$gestionnaireRole->id_role]);

        // On crée 50 utilisateurs supplémentaires pour lier aux propriétaires
        $otherUsers = User::factory(50)->create();
        foreach ($proprietaires->random(50) as $index => $proprio) {
            $proprio->update(['id_utilisateur' => $otherUsers[$index]->id]);
        }
        $this->command->info('Utilisateurs de test créés et liés.');
    }

    private function createPermissions(): array
    {
        $permissions = [];
        $modules = ['syndic', 'copropriete', 'residence', 'lot', 'proprietaire', 'exercice', 'budget', 'facture', 'fournisseur', 'role', 'utilisateur', 'permission', 'type_poste', 'devise'];
        $actions = ['voir', 'creer', 'modifier', 'supprimer'];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissions[] = ['cle' => "{$module}:{$action}", 'nom_permission' => ['fr' => ucfirst($action)." ".ucfirst($module)]];
            }
        }
        return $permissions;
    }
}
