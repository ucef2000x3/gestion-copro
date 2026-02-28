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
        Schema::table('lettrage_paiements', function (Blueprint $table) {
            // ÉTAPE 1: D'abord, supprimer l'ancienne clé primaire composite si elle existe.
            // On récupère le nom de la contrainte pour PostgreSQL.
            $primaryKeyName = DB::select("SELECT conname FROM pg_constraint WHERE conrelid = 'lettrage_paiements'::regclass AND contype = 'p'");
            if (!empty($primaryKeyName)) {
                $table->dropPrimary($primaryKeyName[0]->conname);
            }

            // ÉTAPE 2: Maintenant, on peut ajouter la nouvelle clé primaire simple.
            $table->id()->first();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lettrage_paiements', function (Blueprint $table) {
            // 1. On supprime la clé primaire 'id'
            $table->dropColumn('id');

            // 2. On recrée l'ancienne clé primaire composite
            $table->primary(['id_reglement_proprio', 'id_appel_de_fond_detail']);
        });
    }
};
