<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;       // <<< AJOUTEZ CET IMPORT
use Illuminate\Support\Facades\Schema; // <<< AJOUTEZ CET IMPORT

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('accounting:clear', function () {
    $this->info('Début de la suppression des données comptables...');

    try {
        // On doit désactiver temporairement les contraintes de clés étrangères pour pouvoir vider
        Schema::disableForeignKeyConstraints();

        // Liste des tables à vider, dans un ordre logique (enfants d'abord)
        $tables = [
            'ecritures_comptables',
            'mouvement_tresoreries',
            'lettrage_paiements',
            'appel_de_fond_details',
            'reglements_proprietaires',
            'reglements_factures',
            'appels_de_fonds',
            'factures',
            'operations_diverses',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->warn("Table '{$table}' vidée.");
        }

        // On réactive les contraintes
        Schema::enableForeignKeyConstraints();

        $this->info('Toutes les tables comptables ont été vidées avec succès !');

    } catch (\Exception $e) {
        // En cas d'erreur, on s'assure de réactiver les contraintes
        Schema::enableForeignKeyConstraints();
        $this->error('Une erreur est survenue : ' . $e->getMessage());
        return 1; // Retourne un code d'erreur
    }

    return 0; // Retourne un code de succès

})->purpose('Vider toutes les tables liées aux transactions comptables pour les tests');
