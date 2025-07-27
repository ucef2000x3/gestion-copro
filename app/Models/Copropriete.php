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
    protected $fillable = ['nom_copropriete', 'adresse', 'code_postal', 'ville', 'id_residence', 'statut'];
    protected $casts = ['statut' => 'boolean'];

    public function residence(): BelongsTo
    {
        return $this->belongsTo(Residence::class, 'id_residence');
    }

    public function lots(): HasMany
    {
        return $this->hasMany(Lot::class, 'id_copropriete');
    }

    public function affectations(): MorphMany
    {
        return $this->morphMany(Affectation::class, 'affectable');
    }


}
