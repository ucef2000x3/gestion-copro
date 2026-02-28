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
use App\Models\Exercice;
use App\Models\TypeDePoste;
use App\Models\Fournisseur;
use App\Models\Facture;
use App\Models\AppelDeFonds;
use App\Models\ReglementProprietaire;
use App\Models\OperationDiverse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. RÉINITIALISATION
        Schema::disableForeignKeyConstraints();
        $tables = [
            'lot_proprietaire', 'affectations', 'utilisateur_role', 'role_has_permission', 'permissions',
            'roles', 'proprietaires', 'lots', 'residences', 'coproprietes', 'syndics',
            'users', 'langues', 'exercices', 'types_de_poste', 'budget_postes',
            'reglements_factures', 'factures', 'fournisseurs', 'appels_de_fonds', 'reglements_proprietaires',
            'lettrage_paiements', 'operations_diverses'
        ];
        foreach ($tables as $table) { DB::table($table)->truncate(); }
        Schema::enableForeignKeyConstraints();
        $this->command->info('Toutes les tables ont été vidées.');

        // 2. CONFIGURATION DE BASE
        Langue::create(['code_langue' => 'fr', 'nom' => 'Français']);

        $permissions = $this->createPermissions();
        foreach ($permissions as $permissionData) { Permission::create($permissionData); }
        $this->command->info('Permissions de base créées.');

        $superAdminRole = Role::create(['nom_role' => ['fr' => 'Super Administrateur']]);
        $gestionnaireRole = Role::create(['nom_role' => ['fr' => 'Gestionnaire']]);
        $proprietaireRole = Role::create(['nom_role' => ['fr' => 'Propriétaire']]);
        $superAdminRole->permissions()->sync(Permission::pluck('id_permission'));
        $this->command->info('Rôles de base créés.');

        // 3. DONNÉES MÉTIER
        $syndicA = Syndic::create(['nom_entreprise' => 'Syndic A - Paris Gérance']);
        $syndicB = Syndic::create(['nom_entreprise' => 'Syndic B - Immo Sud']);
        $coproParc = Copropriete::create(['nom_copropriete' => 'Copropriété du Grand Parc', 'id_syndic' => $syndicA->id_syndic]);
        $coproLac = Copropriete::create(['nom_copropriete' => 'Copropriété du Lac', 'id_syndic' => $syndicB->id_syndic]);
        $residenceTilleuls = Residence::create(['nom_residence' => 'Les Tilleuls', 'id_copropriete' => $coproParc->id_copropriete]);
        $residenceNenuphars = Residence::create(['nom_residence' => 'Les Nénuphars', 'id_copropriete' => $coproLac->id_copropriete]);
        $lotA101 = Lot::create(['id_residence' => $residenceTilleuls->id_residence, 'numero_lot' => 'A101', 'nombre_tantiemes' => 120]);
        $lotA102 = Lot::create(['id_residence' => $residenceTilleuls->id_residence, 'numero_lot' => 'A102', 'nombre_tantiemes' => 130]);
        $lotLac5 = Lot::create(['id_residence' => $residenceNenuphars->id_residence, 'numero_lot' => 'Appt 5', 'nombre_tantiemes' => 95]);
        $proprioDupont = Proprietaire::create(['nom' => 'Dupont', 'prenom' => 'Paul', 'email' => 'dupont@example.com']);
        $proprioDurand = Proprietaire::create(['nom' => 'Durand', 'prenom' => 'Marie', 'email' => 'durand@example.com']);
        $lotA101->proprietaires()->sync([$proprioDupont->id_proprietaire => ['pourcentage_possession' => 100]]);
        $lotA102->proprietaires()->sync([$proprioDupont->id_proprietaire => ['pourcentage_possession' => 100]]);
        $lotLac5->proprietaires()->sync([$proprioDurand->id_proprietaire => ['pourcentage_possession' => 100]]);
        $this->command->info('Données métier (hiérarchie & propriétaires) créées.');

        // 4. DONNÉES FINANCIÈRES
        $fournisseurEDF = Fournisseur::create(['nom' => 'EDF']);
        $fournisseurOTIS = Fournisseur::create(['nom' => 'OTIS Ascenseurs']);

        $exercice2025 = Exercice::create(['id_copropriete' => $coproParc->id_copropriete, 'libelle' => 'Exercice 2025', 'date_debut' => '2025-01-01', 'date_fin' => '2025-12-31', 'statut' => StatutExercice::Ouvert]);

        $posteElectricite = TypeDePoste::create(['id_copropriete' => $coproParc->id_copropriete, 'libelle' => 'Électricité des communs']);
        $posteAscenseur = TypeDePoste::create(['id_copropriete' => $coproParc->id_copropriete, 'libelle' => 'Entretien Ascenseur']);

        $budgetElectricite = $exercice2025->budgetPostes()->create(['id_type_poste' => $posteElectricite->id_type_poste, 'montant_previsionnel' => 5000.00]);
        $budgetAscenseur = $exercice2025->budgetPostes()->create(['id_type_poste' => $posteAscenseur->id_type_poste, 'montant_previsionnel' => 3500.00]);

        $factureEDF = Facture::create(['id_syndic' => $syndicA->id_syndic, 'id_fournisseur' => $fournisseurEDF->id_fournisseur, 'id_copropriete' => $coproParc->id_copropriete, 'id_exercice' => $exercice2025->id_exercice, 'id_budget_poste' => $budgetElectricite->id_poste, 'objet' => 'Facture Elec. Janvier', 'date_emission' => '2025-02-15', 'montant_ttc' => 450.00, 'statut' => 'Validée']);
        $factureOTIS = Facture::create(['id_syndic' => $syndicA->id_syndic, 'id_fournisseur' => $fournisseurOTIS->id_fournisseur, 'id_copropriete' => $coproParc->id_copropriete, 'id_exercice' => $exercice2025->id_exercice, 'id_budget_poste' => $budgetAscenseur->id_poste, 'objet' => 'Contrat Ascenseur T1', 'date_emission' => '2025-01-31', 'montant_ttc' => 875.00, 'statut' => 'Payée']);

        $factureOTIS->reglements()->create(['id_exercice' => $exercice2025->id_exercice, 'montant_regle' => 875.00, 'date_reglement' => '2025-02-10', 'mode_de_reglement' => 'Virement']);

        OperationDiverse::create(['id_copropriete' => $coproParc->id_copropriete, 'id_exercice' => $exercice2025->id_exercice, 'id_type_poste' => $posteElectricite->id_type_poste, 'type_operation' => 'Depense', 'montant' => 25.00, 'libelle' => 'Frais bancaires', 'date_operation' => '2025-01-31']);
        $this->command->info('Données financières de test (Budget, Factures, Règlements, OD) créées.');

        $appelT1 = AppelDeFonds::create(['id_lot' => $lotA101->id_lot, 'id_exercice' => $exercice2025->id_exercice, 'libelle' => 'Appel T1 2025', 'montant_appele' => 150.00, 'date_appel' => '2025-01-10', 'date_echeance' => '2025-01-31']);
        $appelT2 = AppelDeFonds::create(['id_lot' => $lotA101->id_lot, 'id_exercice' => $exercice2025->id_exercice, 'libelle' => 'Appel T2 2025', 'montant_appele' => 150.00, 'date_appel' => '2025-04-10', 'date_echeance' => '2025-04-30']);

        $reglementDupont = ReglementProprietaire::create(['id_proprietaire' => $proprioDupont->id_proprietaire, 'id_exercice' => $exercice2025->id_exercice, 'montant_regle' => 200.00, 'date_reglement' => '2025-01-25', 'mode_de_reglement' => 'Virement']);

        $reglementDupont->appelsDeFondsLettres()->attach($appelT1->id_appel_de_fond, ['montant_affecte' => 150.00]);
        $this->command->info('Appels de fonds et règlements de test créés.');

        // 5. UTILISATEURS DE TEST
        $userAdmin = User::factory()->create(['name' => 'Super Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'is_super_admin' => true]);

        $userGestionnaire = User::factory()->create(['name' => 'Gestionnaire Global', 'email' => 'gestion@example.com', 'password' => Hash::make('password')]);
        $gestionnairePermissions = Permission::where('cle', 'not like', 'role:%')->pluck('id_permission');
        $gestionnaireRole->permissions()->sync($gestionnairePermissions);
        $userGestionnaire->roles()->sync([$gestionnaireRole->id_role]);

        $userProprio = User::factory()->create(['name' => 'Paul Dupont', 'email' => 'proprio@example.com', 'password' => Hash::make('password')]);
        $userProprio->roles()->sync([$proprietaireRole->id_role]);
        $proprioDupont->update(['id_utilisateur' => $userProprio->id]);
        $this->command->info('Utilisateurs de test créés.');
    }

    private function createPermissions(): array
    {
        $permissions = [];
        $modules = ['syndic', 'copropriete', 'residence', 'lot', 'proprietaire', 'exercice', 'budget', 'facture', 'fournisseur', 'role', 'utilisateur', 'permission', 'type_poste', 'devise', 'reglement_proprio', 'reglement_facture', 'operation_diverse'];
        $actions = ['voir', 'creer', 'modifier', 'supprimer', 'payer', 'valider', 'cloturer']; // Actions exhaustives
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                // Créer la permission uniquement si elle a du sens (ex: pas de 'payer' pour un syndic)
                if (in_array($action, ['voir', 'creer', 'modifier', 'supprimer'])) {
                    $permissions[] = ['cle' => "{$module}:{$action}", 'nom_permission' => ['fr' => ucfirst($action)." ".ucfirst($module)]];
                }
            }
        }
        $permissions[] = ['cle' => "facture:payer", 'nom_permission' => ['fr' => "Payer Facture"]];
        $permissions[] = ['cle' => "facture:valider", 'nom_permission' => ['fr' => "Valider Facture"]];
        $permissions[] = ['cle' => "exercice:cloturer", 'nom_permission' => ['fr' => "Clôturer Exercice"]];
        return $permissions;
    }
}
