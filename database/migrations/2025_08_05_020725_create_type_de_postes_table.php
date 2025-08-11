<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('types_de_poste', function (Blueprint $table) {
            $table->id('id_type_poste');
            $table->foreignId('id_copropriete')->constrained('coproprietes', 'id_copropriete')->onDelete('cascade');
            $table->string('libelle');
            $table->string('code_comptable')->nullable();
            $table->boolean('statut')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('types_de_poste');
    }
};
