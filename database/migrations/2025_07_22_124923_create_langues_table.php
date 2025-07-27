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
        Schema::create('langues', function (Blueprint $table) {
            $table->id('id_langue');
            $table->string('code_langue', 5)->unique(); // ex: 'fr', 'en', 'es'
            $table->string('nom'); // ex: 'Français', 'English'
            $table->boolean('est_active')->default(true); // Pour activer/désactiver une langue
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('langues');
    }
};
