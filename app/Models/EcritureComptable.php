<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EcritureComptable extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $table = 'ecritures_comptables';
    protected $guarded = [];

    /**
     * Obtenir le modèle parent (document) de l'écriture (ReglementFacture, ReglementProprietaire, etc.).
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}
