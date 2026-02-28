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
        Schema::create('reglements_proprietaires', function (Blueprint $table) {
            $table->id('id_reglement_proprio');
            $table->foreignId('id_proprietaire')->constrained('proprietaires', 'id_proprietaire');
            $table->foreignId('id_exercice')->constrained('exercices', 'id_exercice');

            $table->decimal('montant_regle', 15, 2);
            $table->date('date_reglement');
            $table->string('mode_de_reglement'); // 'Virement', 'Chèque', etc.
            $table->string('reference_paiement')->nullable();
            $table->string('statut')->default('Non lettré'); // 'Non lettré', 'Partiellement lettré', 'Lettré'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reglement_proprietaires');
    }
};
