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
        Schema::table('coproprietes', function (Blueprint $table) {
            $table->foreignId('id_devise')->nullable()->after('id_syndic')->constrained('devises', 'id_devise');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coproprietes', function (Blueprint $table) {
            $table->dropForeign(['id_devise']);
            $table->dropColumn('id_devise');
        });
    }
};
