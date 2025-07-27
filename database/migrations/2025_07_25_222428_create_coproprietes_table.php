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
        Schema::create('coproprietes', function (Blueprint $table) {
            $table->id('id_copropriete');
            $table->string('nom_copropriete');
            $table->string('adresse')->nullable();
            $table->string('code_postal', 10)->nullable();
            $table->string('ville')->nullable();

            // Relation avec Résidences
            $table->foreignId('id_residence')
                ->constrained('residences', 'id_residence')
                ->onDelete('cascade');

            $table->boolean('statut')->default(true); // Ajout du champ statut
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coproprietes');
    }
};
