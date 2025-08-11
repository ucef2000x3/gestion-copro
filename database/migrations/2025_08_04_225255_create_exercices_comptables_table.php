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
            $table->string('statut')->default('Ouvert'); // 'Planifié', 'Ouvert', 'Clôturé'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercices_comptables');
    }
};
