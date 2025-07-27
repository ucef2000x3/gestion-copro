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
        Schema::create('exercices_comptables', function (Blueprint $table) {
            $table->id('id_exercice');

            $table->foreignId('id_copropriete')
                ->constrained('coproprietes', 'id_copropriete')
                ->onDelete('cascade');

            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('statut')->default('Ouvert'); // 'Planifié', 'Ouvert', 'En cours de clôture', 'Clôturé'

            // On laisse les champs pour la clôture pour plus tard, la structure de base est suffisante.

            $table->timestamps();

            // On s'assure qu'une copropriété ne peut pas avoir deux exercices qui se chevauchent.
            // C'est une contrainte de base de données avancée. Pour l'instant, on gérera en validation.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercice_comptables');
    }
};
