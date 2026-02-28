<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('comptes_bancaires', function (Blueprint $table) {
            $table->id('id_compte_bancaire');
            $table->foreignId('id_copropriete')->constrained('coproprietes', 'id_copropriete');
            $table->string('type_compte')->default('banque'); // 'banque' ou 'caisse'
            $table->string('nom_compte');
            $table->string('iban')->nullable()->unique();
            $table->string('nom_banque')->nullable();
            $table->decimal('solde_initial', 15, 2)->default(0);
            $table->boolean('statut')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('comptes_bancaires'); }
};
