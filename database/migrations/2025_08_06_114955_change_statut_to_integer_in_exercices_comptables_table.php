<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Étape 1: On supprime l'ancienne contrainte de valeur par défaut
        DB::statement('ALTER TABLE exercices_comptables ALTER COLUMN statut DROP DEFAULT;');

        // Étape 2: On change le type de la colonne en convertissant les valeurs existantes
        DB::statement("
            ALTER TABLE exercices_comptables
            ALTER COLUMN statut TYPE smallint
            USING CASE
                WHEN statut = 'Ouvert' THEN 1
                WHEN statut = 'Planifié' THEN 2
                WHEN statut = 'Clôturé' THEN 3
                ELSE 1
            END;
        ");

        // Étape 3: On ajoute la nouvelle contrainte de valeur par défaut (un entier)
        DB::statement('ALTER TABLE exercices_comptables ALTER COLUMN statut SET DEFAULT 1;');
    }

    public function down(): void
    {
        // Opérations inverses
        DB::statement('ALTER TABLE exercices_comptables ALTER COLUMN statut DROP DEFAULT;');

        DB::statement("
            ALTER TABLE exercices_comptables
            ALTER COLUMN statut TYPE varchar(255)
            USING CASE
                WHEN statut = 1 THEN 'Ouvert'
                WHEN statut = 2 THEN 'Planifié'
                WHEN statut = 3 THEN 'Clôturé'
                ELSE 'Ouvert'
            END;
        ");

        DB::statement("ALTER TABLE exercices_comptables ALTER COLUMN statut SET DEFAULT 'Ouvert';");
    }
};
