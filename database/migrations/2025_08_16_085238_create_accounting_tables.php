<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Table pour les écritures comptables (principe de la partie double)
        Schema::create('ecritures_comptables', function (Blueprint $table) {
            $table->id();

            // DÉBUT DE LA CORRECTION
            // On définit les colonnes qui serviront de clé étrangère
            $table->unsignedBigInteger('id_exercice');
            $table->unsignedBigInteger('id_copropriete');
            // FIN DE LA CORRECTION

            $table->morphs('documentable'); // Crée documentable_id et documentable_type
            $table->string('numero_compte'); // Ex: '401000' (Fournisseur), '512000' (Banque)
            $table->string('libelle');
            $table->decimal('debit', 15, 2)->nullable()->default(0);
            $table->decimal('credit', 15, 2)->nullable()->default(0);
            $table->date('date_ecriture');
            $table->timestamps();

            $table->index(['documentable_id', 'documentable_type']);

            // DÉBUT DE LA CORRECTION
            // On définit explicitement la contrainte en spécifiant la colonne de référence
            $table->foreign('id_exercice')->references('id_exercice')->on('exercices')->cascadeOnDelete();
            $table->foreign('id_copropriete')->references('id_copropriete')->on('coproprietes')->cascadeOnDelete();
            // FIN DE LA CORRECTION
        });

        // Table pour suivre les flux de trésorerie de manière simplifiée
        Schema::create('mouvement_tresoreries', function (Blueprint $table) {
            $table->id();

            // DÉBUT DE LA CORRECTION
            $table->unsignedBigInteger('id_copropriete');
            // FIN DE LA CORRECTION

            $table->morphs('sourceable'); // Crée sourceable_id et sourceable_type
            $table->enum('type', ['encaissement', 'decaissement']);
            $table->decimal('montant', 15, 2);
            $table->string('libelle');
            $table->date('date_mouvement');
            $table->timestamps();

            $table->index(['sourceable_id', 'sourceable_type']);

            // DÉBUT DE LA CORRECTION
            $table->foreign('id_copropriete')->references('id_copropriete')->on('coproprietes')->cascadeOnDelete();
            // FIN DE LA CORRECTION
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecritures_comptables');
        Schema::dropIfExists('mouvement_tresoreries');
    }
};
