<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('comptes_bancaires', function (Blueprint $table) {
            $table->string('compte_comptable')->nullable()->after('nom_banque');
        });
        Schema::table('proprietaires', function (Blueprint $table) {
            $table->string('compte_comptable')->nullable()->after('bic');
        });
        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->string('compte_comptable')->nullable()->after('nom');
        });
    }
    public function down(): void
    {
        Schema::table('comptes_bancaires', function (Blueprint $table) { $table->dropColumn('compte_comptable'); });
        Schema::table('proprietaires', function (Blueprint $table) { $table->dropColumn('compte_comptable'); });
        Schema::table('fournisseurs', function (Blueprint $table) { $table->dropColumn('compte_comptable'); });
    }
};
