<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Copropriete extends Model
{
    use HasFactory, HasStatus;

    protected $primaryKey = 'id_copropriete';

    protected $fillable = [
        'nom_copropriete',
        'id_syndic',
        'id_devise',
        'statut',
    ];

    protected $casts = [
        'statut' => 'boolean',
    ];

    /**
     * Définit la relation : Une Résidence APPARTIENT À (belongsTo) un Syndic.
     */
    public function syndic(): BelongsTo
    {
        return $this->belongsTo(Syndic::class, 'id_syndic');
    }

    public function affectations(): MorphMany
    {
        return $this->morphMany(Affectation::class, 'affectable');
    }

    public function residences(): HasMany
    {
        return $this->hasMany(Residence::class, 'id_copropriete');
    }

    public function exercicesComptables(): HasMany
    {
        return $this->hasMany(ExerciceComptable::class, 'id_copropriete');
    }

    public function typesDePoste(): HasMany
    {
        return $this->hasMany(TypeDePoste::class, 'id_copropriete');
    }

    public function devise(): BelongsTo
    {
        return $this->belongsTo(Devise::class, 'id_devise');
    }

    /**
     * Récupère toutes les factures associées à cette copropriété.
     */
    public function factures(): HasMany
    {
        return $this->hasMany(Facture::class, 'id_copropriete');
    }

    /**
     * Récupère TOUS les lots d'une copropriété EN PASSANT PAR les résidences.
     */
    public function lots(): HasManyThrough
    {
        // La relation se lit : "Ce modèle (Copropriete) A PLUSIEURS (hasMany) Lots À TRAVERS (through) le modèle Residence"
        return $this->hasManyThrough(
            Lot::class,       // Le modèle final que l'on veut atteindre
            Residence::class, // Le modèle intermédiaire
            'id_copropriete', // La clé étrangère sur la table intermédiaire (residences)
            'id_residence',   // La clé étrangère sur la table finale (lots)
            'id_copropriete', // La clé locale sur cette table (coproprietes)
            'id_residence'    // La clé locale sur la table intermédiaire (residences)
        );
    }




}
