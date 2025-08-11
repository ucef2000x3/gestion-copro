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
        Schema::create('appels_de_fonds', function (Blueprint $table) {
            $table->id('id_appel_de_fond');

            $table->foreignId('id_lot')->constrained('lots', 'id_lot');
            $table->foreignId('id_exercice')->constrained('exercices_comptables', 'id_exercice');

            $table->string('libelle'); // Ex: "Appel de fonds T1 2025", "Régularisation charges 2024"
            $table->decimal('montant_appele', 15, 2);

            $table->date('date_appel');
            $table->date('date_echeance');

            $table->string('statut')->default('A payer'); // 'A payer', 'Partiellement payé', 'Payé', 'En retard'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appel_de_fonds');
    }
};
