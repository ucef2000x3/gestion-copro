<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\HasStatus;

class Residence extends Model
{
    use HasFactory, HasStatus;
    protected $primaryKey = 'id_residence';
    protected $fillable = ['nom_residence', 'adresse', 'code_postal', 'ville', 'id_copropriete', 'statut'];
    protected $casts = ['statut' => 'boolean'];

    public function copropriete(): BelongsTo
    {
        return $this->belongsTo(Copropriete::class, 'id_copropriete');
    }

    public function lots(): HasMany
    {
        return $this->hasMany(Lot::class, 'id_residence');
    }

    public function affectations(): MorphMany
    {
        return $this->morphMany(Affectation::class, 'affectable');
    }

    public function getRouteKeyName()
    {
        // =========================================================
        // == CORRECTION N°2 : LA CLÉ POUR LES ROUTES ==
        // =========================================================
        // On s'assure que Laravel utilise bien cette colonne pour générer les URLs.
        return 'id_residence';
    }


}
