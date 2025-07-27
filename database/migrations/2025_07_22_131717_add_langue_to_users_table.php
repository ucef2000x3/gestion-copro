<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cette méthode est exécutée quand on lance `php artisan migrate`.
     */
    public function up(): void
    {
        // On dit à Laravel qu'on veut travailler sur la table 'users'
        Schema::table('users', function (Blueprint $table) {
            // On ajoute la nouvelle colonne pour la clé étrangère.
            // Elle est "nullable" car un utilisateur peut ne pas avoir de préférence.
            // Elle est placée "after" une autre colonne pour l'organisation (optionnel).
            $table->foreignId('id_langue_preferee')
                ->nullable()
                ->after('remember_token') // Vous pouvez choisir une autre colonne si vous voulez
                ->constrained('langues', 'id_langue')
                ->onDelete('set null'); // Optionnel mais bonne pratique: si une langue est supprimée, la préférence des utilisateurs passe à NULL.
        });
    }

    /**
     * Reverse the migrations.
     * Cette méthode est exécutée pour annuler la migration (rollback).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Pour annuler, on doit d'abord supprimer la contrainte de clé étrangère
            $table->dropForeign(['id_langue_preferee']);
            // Puis on supprime la colonne
            $table->dropColumn('id_langue_preferee');
        });
    }
};
