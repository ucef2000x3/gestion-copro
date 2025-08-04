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
            $table->foreignId('id_lot')->constrained('lots', 'id_lot')->onDelete('cascade');
            $table->foreignId('id_proprietaire')->constrained('proprietaires', 'id_proprietaire')->onDelete('cascade');
            $table->decimal('pourcentage_possession', 5, 2)->default(100.00);
            $table->timestamps();
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
