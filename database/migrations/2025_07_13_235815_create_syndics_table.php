<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécutée quand on lance `php artisan migrate`.
     */
    public function up(): void
    {
        Schema::create('syndics', function (Blueprint $table) {
            // $table->id('id_syndic');
            // Crée une colonne `id_syndic` de type BIGINT, auto-incrémentée, et clé primaire.
            $table->id('id_syndic');

            // Crée une colonne `nom_entreprise` de type VARCHAR(255), qui ne peut pas être nulle.
            $table->string('nom_entreprise');

            // Crée automatiquement deux colonnes :
            // `created_at` (DATETIME, nullable)
            // `updated_at` (DATETIME, nullable)
            // Laravel les remplit automatiquement.
            $table->timestamps();
        });
    }

    /**
     * Exécutée quand on lance `php artisan migrate:rollback`.
     */
    public function down(): void
    {
        Schema::dropIfExists('syndics');
    }
};
