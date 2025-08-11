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
        Schema::create('budget_postes', function (Blueprint $table) {
            $table->id('id_poste');

            $table->foreignId('id_exercice')
                ->constrained('exercices_comptables', 'id_exercice')
                ->onDelete('cascade');

            $table->foreignId('id_type_poste')
                ->constrained('types_de_poste', 'id_type_poste')
                ->onDelete('cascade');

            $table->decimal('montant_previsionnel', 15, 2);

            $table->timestamps();

            // Un type de poste ne peut apparaître qu'une seule fois par exercice.
            $table->unique(['id_exercice', 'id_type_poste']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_postes');
    }
};
