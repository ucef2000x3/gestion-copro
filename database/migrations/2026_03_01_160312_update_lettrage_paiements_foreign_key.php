<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('lettrage_paiements')->truncate();
        Schema::table('lettrage_paiements', function (Blueprint $table) {
            // 1. Supprimer l'ancienne contrainte de clé étrangère
            $table->dropForeign(['id_appel_de_fond']);

            // 2. Renommer la colonne
            $table->renameColumn('id_appel_de_fond', 'id_appel_de_fond_detail');

            // 3. Ajouter la nouvelle contrainte de clé étrangère
            $table->foreign('id_appel_de_fond_detail')
                ->references('id')->on('appel_de_fond_details')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lettrage_paiements', function (Blueprint $table) {
            $table->dropForeign(['id_appel_de_fond_detail']);
            $table->renameColumn('id_appel_de_fond_detail', 'id_appel_de_fond');
            $table->foreign('id_appel_de_fond')
                ->references('id_appel_de_fond')->on('appels_de_fonds')
                ->cascadeOnDelete();
        });
    }
};
