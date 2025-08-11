<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Concerns\HasStatus;

class Syndic extends Model
{
    use HasFactory, HasStatus;
    protected $primaryKey = 'id_syndic';

    protected $fillable = [
        'nom_entreprise',
        'statut'
    ];

    protected $casts = [
        'statut' => 'boolean',
    ];

    /**
     * Définit la relation inverse : Un Syndic A PLUSIEURS (hasMany) Résidences.
     */
    public function coproprietes(): HasMany
    {
        return $this->hasMany(Copropriete::class, 'id_syndic');
    }

    public function affectations(): MorphMany
    {
        return $this->morphMany(Affectation::class, 'affectable');
    }

    /**
     * Récupère toutes les factures gérées par ce syndic.
     */
    public function factures(): HasMany
    {
        return $this->hasMany(Facture::class, 'id_syndic');
    }


}
