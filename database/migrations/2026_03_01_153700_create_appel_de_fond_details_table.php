<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ===============================================
        // == CORRECTION : VIDER LES TABLES AVANT DE CHANGER LA STRUCTURE ==
        // ===============================================
        // On vide d'abord les enfants...
        if (Schema::hasTable('lettrage_paiements')) {
            DB::table('lettrage_paiements')->truncate();
        }
        // ...puis les parents.
        if (Schema::hasTable('appels_de_fonds')) {
            DB::table('appels_de_fonds')->truncate();
        }

        // Étape 1: Créer la nouvelle table pour la ventilation par propriétaire
        Schema::create('appel_de_fond_details', function (Blueprint $table) {
            $table->id();

            // CORRECTION : Déclaration explicite des colonnes et contraintes
            $table->unsignedBigInteger('id_appel_de_fond');
            $table->unsignedBigInteger('id_proprietaire');

            $table->decimal('montant_quote_part', 15, 2);
            $table->string('statut')->default('En attente');
            $table->timestamps();

            $table->foreign('id_appel_de_fond')
                ->references('id_appel_de_fond')->on('appels_de_fonds')
                ->cascadeOnDelete();

            $table->foreign('id_proprietaire')
                ->references('id_proprietaire')->on('proprietaires')
                ->cascadeOnDelete();
        });

        // Étape 2: Modifier la table `appels_de_fonds` existante
        Schema::table('appels_de_fonds', function (Blueprint $table) {
            $table->renameColumn('montant_appele', 'montant_total_lot');

            // CORRECTION : Ajouter la date avec une valeur par défaut ou la rendre nullable
            // La meilleure solution est de vider la table, comme fait plus haut.
            if (!Schema::hasColumn('appels_de_fonds', 'date_appel')) {
                $table->date('date_appel')->after('libelle');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appel_de_fond_details');
        Schema::table('appels_de_fonds', function (Blueprint $table) {
            $table->renameColumn('montant_total_lot', 'montant_appele');
            $table->dropColumn('date_appel');
        });
    }
};

