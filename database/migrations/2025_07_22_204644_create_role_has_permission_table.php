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
            // Clé étrangère vers la table des rôles.
            // Si un rôle est supprimé, toutes ses associations dans cette table sont supprimées.
            $table->foreignId('id_role')
                ->constrained('roles', 'id_role')
                ->onDelete('cascade');

            // Clé étrangère vers la table des permissions.
            // Si une permission est supprimée, toutes ses associations sont supprimées.
            $table->foreignId('id_permission')
                ->constrained('permissions', 'id_permission')
                ->onDelete('cascade');

            // Clé primaire composite.
            // Cela garantit qu'on ne peut pas assigner la même permission deux fois au même rôle.
            // C'est aussi un index qui accélère les recherches.
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
