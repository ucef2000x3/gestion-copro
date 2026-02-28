<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('types_de_poste', function (Blueprint $table) {
            $table->string('nature')->default('charge')->after('code_comptable');
        });
    }
    public function down(): void {
        Schema::table('types_de_poste', function (Blueprint $table) {
            $table->dropColumn('nature');
        });
    }
};
