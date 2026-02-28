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
        Schema::create('reglements_factures', function (Blueprint $table) {
            $table->id('id_reglement');
            $table->foreignId('id_facture')->constrained('factures', 'id_facture')->onDelete('cascade');
            $table->foreignId('id_exercice')->constrained('exercices', 'id_exercice');

            $table->decimal('montant_regle', 15, 2);
            $table->date('date_reglement');
            $table->string('mode_de_reglement');
            $table->string('reference_reglement')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reglement_factures');
    }
};
