<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proprietaires', function (Blueprint $table) {
            $table->id('id_proprietaire');

            // Lien optionnel vers un compte utilisateur pour l'accès à l'extranet
            $table->foreignId('id_utilisateur')->nullable()->constrained('users', 'id')->onDelete('set null');

            // Champs pour distinguer Personne Physique / Morale
            $table->string('type_proprietaire')->default('personne_physique'); // 'personne_physique' ou 'personne_morale'

            // Champs communs
            $table->string('nom'); // Nom de famille OU Raison sociale
            $table->string('email')->nullable(); // Email de contact officiel
            $table->string('telephone_contact')->nullable();
            $table->string('adresse_postale')->nullable();
            $table->string('code_postal', 10)->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->nullable();

            // Champs spécifiques Personne Physique
            $table->string('civilite')->nullable(); // 'M.', 'Mme'
            $table->string('prenom')->nullable();
            $table->date('date_naissance')->nullable();

            // Champs spécifiques Personne Morale
            $table->string('forme_juridique')->nullable(); // 'SCI', 'SARL'...
            $table->string('numero_siret')->nullable();

            // Informations financières (devraient être chiffrées en production)
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();

            $table->text('commentaires')->nullable();
            $table->boolean('statut')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proprietaires');
    }
};
