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
        Schema::create('operations_diverses', function (Blueprint $table) {
            $table->id('id_operation_diverse');
            $table->foreignId('id_copropriete')->constrained('coproprietes', 'id_copropriete');
            $table->foreignId('id_exercice')->constrained('exercices', 'id_exercice');

            // LIAISON VERS LE CATALOGUE DE POSTES (VOTRE SUGGESTION)
            // C'est la "Catégorie" de l'opération.
            $table->foreignId('id_type_poste')->constrained('types_de_poste', 'id_type_poste');

            // On ajoutera plus tard le compte bancaire
            // $table->foreignId('id_compte_bancaire')->constrained('comptes_bancaires');

            $table->string('type_operation'); // 'Depense' ou 'Recette'
            $table->decimal('montant', 15, 2);
            $table->string('libelle');
            $table->date('date_operation');
            $table->string('tiers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_diverses');
    }
};
