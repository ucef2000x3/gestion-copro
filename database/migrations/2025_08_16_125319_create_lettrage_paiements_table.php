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
        Schema::create('lettrage_paiements', function (Blueprint $table) {
            $table->id('id_lettrage');
            $table->foreignId('id_reglement_proprio')->constrained('reglements_proprietaires', 'id_reglement_proprio')->onDelete('cascade');
            $table->foreignId('id_appel_de_fond')->constrained('appels_de_fonds', 'id_appel_de_fond')->onDelete('cascade');
            $table->decimal('montant_affecte', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lettrage_paiements');
    }
};
