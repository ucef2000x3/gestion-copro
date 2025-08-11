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
        Schema::create('factures', function (Blueprint $table) {
            $table->id('id_facture');

            $table->foreignId('id_syndic')->constrained('syndics', 'id_syndic');
            $table->foreignId('id_fournisseur')->constrained('fournisseurs', 'id_fournisseur');
            $table->foreignId('id_copropriete')->constrained('coproprietes', 'id_copropriete');

// Une facture est liée à un exercice pour le reporting comptable
            $table->foreignId('id_exercice')->constrained('exercices_comptables', 'id_exercice');

            $table->foreignId('id_budget_poste')->nullable()->constrained('budget_postes', 'id_poste');

            $table->string('numero_facture')->nullable();
            $table->string('objet');
            $table->string('statut')->default('A valider'); // 'A valider', 'Validée', 'Payée', 'Annulée'

            $table->date('date_emission');
            $table->date('date_echeance')->nullable();

            $table->decimal('montant_ht', 15, 2)->nullable();
            $table->decimal('montant_tva', 15, 2)->nullable();
            $table->decimal('montant_ttc', 15, 2);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
