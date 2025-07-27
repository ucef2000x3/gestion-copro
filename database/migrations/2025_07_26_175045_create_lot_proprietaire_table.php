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
        Schema::create('lot_proprietaire', function (Blueprint $table) {
            // Clé étrangère vers la table 'lots'
            $table->foreignId('id_lot')
                ->constrained('lots', 'id_lot')
                ->onDelete('cascade');

            // Clé étrangère vers la table 'proprietaires'
            $table->foreignId('id_proprietaire')
                ->constrained('proprietaires', 'id_proprietaire')
                ->onDelete('cascade');

            // Le pourcentage de possession pour ce propriétaire sur ce lot
            $table->decimal('pourcentage_possession', 5, 2)->default(100.00);

            // Clé primaire composite pour éviter les doublons (un propriétaire ne peut être
            // lié qu'une seule fois au même lot) et pour l'indexation.
            $table->primary(['id_lot', 'id_proprietaire']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lot_proprietaire');
    }
};
