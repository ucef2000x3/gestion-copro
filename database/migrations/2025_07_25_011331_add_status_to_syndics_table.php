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
        Schema::table('syndics', function (Blueprint $table) {
            // Ajoute une colonne booléenne après 'nom_entreprise'
            // Par défaut, tout nouvel enregistrement est 'actif'.
            $table->boolean('est_actif')->default(true)->after('nom_entreprise');
        });
    }
    public function down(): void
    {
        Schema::table('syndics', function (Blueprint $table) { $table->dropColumn('est_actif'); });
    }
};
