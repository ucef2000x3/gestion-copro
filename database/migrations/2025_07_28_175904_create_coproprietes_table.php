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
        Schema::create('coproprietes', function (Blueprint $table) {
            $table->id('id_copropriete');
            $table->foreignId('id_syndic')->constrained('syndics', 'id_syndic')->onDelete('cascade');
            $table->string('nom_copropriete');
            $table->boolean('statut')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coproprietes');
    }
};
