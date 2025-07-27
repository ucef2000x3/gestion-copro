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
        Schema::create('affectations', function (Blueprint $table) {
            $table->id('id_affectation');
            $table->foreignId('id_utilisateur')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('id_role')->constrained('roles', 'id_role')->onDelete('cascade');

            // La relation polymorphe: affectable_id (BIGINT) et affectable_type (VARCHAR)
            $table->morphs('affectable');

            $table->timestamps();
            //$table->index(['affectable_type', 'affectable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};
