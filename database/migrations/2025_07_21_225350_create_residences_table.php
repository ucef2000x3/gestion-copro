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
        Schema::create('residences', function (Blueprint $table) {
            $table->id('id_residence');
            $table->string('nom_residence');

            // CRUCIAL : La clé étrangère
            // Crée une colonne 'id_syndic' et une contrainte qui la lie
            // à la colonne 'id_syndic' de la table 'syndics'.
            $table->foreignId('id_syndic')
                ->constrained('syndics', 'id_syndic')
                ->onDelete('cascade'); // Si un syndic est supprimé, ses résidences le sont aussi.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residences');
    }
};
