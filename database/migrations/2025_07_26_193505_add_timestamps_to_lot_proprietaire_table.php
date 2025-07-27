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
        Schema::table('lot_proprietaire', function (Blueprint $table) {
            // Ajoute les colonnes `created_at` et `updated_at` (nullable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lot_proprietaire', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
