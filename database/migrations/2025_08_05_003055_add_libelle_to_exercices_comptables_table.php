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
        Schema::table('exercices_comptables', function (Blueprint $table) {
            // On ajoute la colonne `libelle` après `id_copropriete` pour une meilleure or
            //ganisation
            $table->string('libelle')->nullable()->after('id_copropriete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercices_comptables', function (Blueprint $table) {
            $table->dropColumn('libelle');
        });
    }
};
