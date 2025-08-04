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
        Schema::create('proprietaires', function (Blueprint $table) {
            $table->id('id_proprietaire');
            $table->foreignId('id_utilisateur')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->string('type_proprietaire')->default('personne_physique');
            $table->string('nom');
            $table->string('email')->nullable();
            $table->string('telephone_contact')->nullable();
            $table->string('adresse_postale')->nullable();
            $table->string('code_postal', 10)->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->nullable();
            $table->string('civilite')->nullable();
            $table->string('prenom')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('forme_juridique')->nullable();
            $table->string('numero_siret')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
            $table->text('commentaires')->nullable();
            $table->boolean('statut')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proprietaires');
    }
};
