<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\HasStatus;

class Copropriete extends Model
{
    use HasFactory, HasStatus;

    protected $primaryKey = 'id_copropriete';

    protected $fillable = [
        'nom_copropriete',
        'id_syndic',
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
}
