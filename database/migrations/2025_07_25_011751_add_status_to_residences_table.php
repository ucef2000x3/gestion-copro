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
        Schema::table('residences', function (Blueprint $table) {
            $table->boolean('est_actif')->default(true)->after('nom_residence');
        });
    }
    public function down(): void { Schema::table('residences', function (Blueprint $table) { $table->dropColumn('est_actif'); }); }
};
