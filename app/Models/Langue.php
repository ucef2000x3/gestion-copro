<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    use HasFactory;

    /**
     * Le nom de la clé primaire pour le modèle.
     *
     * @var string
     */
    protected $primaryKey = 'id_langue'; // <<<--- LA LIGNE À AJOUTER

    /**
     * Indique au modèle de ne pas gérer automatiquement les timestamps.
     * A enlever si vous ajoutez `$table->timestamps()` à la migration.
     *
     * @var bool
     */
    // public $timestamps = false; // A DECOMMENTER SI VOUS NE VOULEZ PAS created_at/updated_at

    /**
     * Les attributs qui sont assignables massivement.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code_langue',
        'nom',
        'est_active',
    ];
}
