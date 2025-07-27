<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('syndics', function (Blueprint $table) {
            // Renomme la colonne 'est_actif' en 'statut'
            $table->renameColumn('est_actif', 'statut');
        });
    }

    public function down(): void
    {
        Schema::table('syndics', function (Blueprint $table) {
            // Définit l'opération inverse pour le rollback
            $table->renameColumn('statut', 'est_actif');
        });
    }
};
