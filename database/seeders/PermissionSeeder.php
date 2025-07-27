<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // On vide la table avant de la remplir pour éviter les doublons
        Permission::truncate();

        $permissions = [
            // --- GESTION DES SYNDICS ---
            ['cle' => 'syndic:voir', 'nom_permission' => ['fr' => 'Voir les Syndics', 'en' => 'View Syndics']],
            ['cle' => 'syndic:creer', 'nom_permission' => ['fr' => 'Créer un Syndic', 'en' => 'Create Syndic']],
            ['cle' => 'syndic:modifier', 'nom_permission' => ['fr' => 'Modifier un Syndic', 'en' => 'Edit Syndic']],
            ['cle' => 'syndic:supprimer', 'nom_permission' => ['fr' => 'Supprimer un Syndic', 'en' => 'Delete Syndic']],

            // --- GESTION DES RÉSIDENCES ---
            ['cle' => 'residence:voir', 'nom_permission' => ['fr' => 'Voir les Résidences', 'en' => 'View Residences']],
            ['cle' => 'residence:creer', 'nom_permission' => ['fr' => 'Créer une Résidence', 'en' => 'Create Residence']],
            ['cle' => 'residence:modifier', 'nom_permission' => ['fr' => 'Modifier une Résidence', 'en' => 'Edit Residence']],
            ['cle' => 'residence:supprimer', 'nom_permission' => ['fr' => 'Supprimer une Résidence', 'en' => 'Delete Residence']],

            // --- GESTION DES RÔLES & PERMISSIONS ---
            ['cle' => 'role:voir', 'nom_permission' => ['fr' => 'Voir les Rôles', 'en' => 'View Roles']],
            ['cle' => 'role:creer', 'nom_permission' => ['fr' => 'Créer un Rôle', 'en' => 'Create Role']],
            ['cle' => 'role:modifier', 'nom_permission' => ['fr' => 'Modifier un Rôle', 'en' => 'Edit Role']],
            ['cle' => 'role:supprimer', 'nom_permission' => ['fr' => 'Supprimer un Rôle', 'en' => 'Delete Role']],
            ['cle' => 'role:assigner-permissions', 'nom_permission' => ['fr' => 'Assigner des Permissions', 'en' => 'Assign Permissions']],

            // --- GESTION DES UTILISATEURS ---
            ['cle' => 'utilisateur:voir', 'nom_permission' => ['fr' => 'Voir les Utilisateurs', 'en' => 'View Users']],
            ['cle' => 'utilisateur:assigner-roles', 'nom_permission' => ['fr' => 'Assigner des Rôles', 'en' => 'Assign Roles']],

        ];

        // On insère les données dans la base
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
