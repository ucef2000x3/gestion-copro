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
        Schema::create('imputations_facture', function (Blueprint $table) {
            $table->id('id_imputation');
            $table->foreignId('id_facture')->constrained('factures', 'id_facture')->onDelete('cascade');
            $table->foreignId('id_poste')->constrained('budget_postes', 'id_poste')->onDelete('cascade');
            $table->decimal('montant_impute', 15, 2);
            $table->timestamps();
            $table->unique(['id_facture', 'id_poste']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imputations_facture');
    }
};
