<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reglements_factures', function (Blueprint $table) {
            // CORRECTION : On décompose la commande
            $table->unsignedBigInteger('id_compte_bancaire')->nullable()->after('id_exercice');
            $table->foreign('id_compte_bancaire')
                ->references('id_compte_bancaire')->on('comptes_bancaires')
                ->nullOnDelete();
        });

        Schema::table('reglements_proprietaires', function (Blueprint $table) {
            // CORRECTION : On décompose la commande
            $table->unsignedBigInteger('id_compte_bancaire')->nullable()->after('id_exercice');
            $table->foreign('id_compte_bancaire')
                ->references('id_compte_bancaire')->on('comptes_bancaires')
                ->nullOnDelete();
        });

        Schema::table('operations_diverses', function (Blueprint $table) {
            // CORRECTION : On décompose la commande
            $table->unsignedBigInteger('id_compte_bancaire')->nullable()->after('id_exercice');
            $table->foreign('id_compte_bancaire')
                ->references('id_compte_bancaire')->on('comptes_bancaires')
                ->nullOnDelete();
        });
    }
    public function down(): void
    {
        Schema::table('reglements_factures', function (Blueprint $table) { $table->dropForeign(['id_compte_bancaire']); $table->dropColumn('id_compte_bancaire'); });
        Schema::table('reglements_proprietaires', function (Blueprint $table) { $table->dropForeign(['id_compte_bancaire']); $table->dropColumn('id_compte_bancaire'); });
        Schema::table('operations_diverses', function (Blueprint $table) { $table->dropForeign(['id_compte_bancaire']); $table->dropColumn('id_compte_bancaire'); });
    }
};
