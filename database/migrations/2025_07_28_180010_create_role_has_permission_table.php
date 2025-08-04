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
        Schema::create('role_has_permission', function (Blueprint $table) {
            $table->foreignId('id_role')->constrained('roles', 'id_role')->onDelete('cascade');
            $table->foreignId('id_permission')->constrained('permissions', 'id_permission')->onDelete('cascade');
            $table->primary(['id_role', 'id_permission']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_permission');
    }
};
