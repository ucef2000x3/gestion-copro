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
        Schema::create('lots', function (Blueprint $table) {
            $table->id('id_lot');

            $table->foreignId('id_copropriete')
                ->constrained('coproprietes', 'id_copropriete')
                ->onDelete('cascade');

            $table->string('numero_lot');
            $table->unsignedInteger('nombre_tantiemes')->default(0);

            $table->boolean('statut')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
