<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Concerns\HasStatus;

class Lot extends Model
{
    use HasFactory, HasStatus;
    protected $primaryKey = 'id_lot';
    protected $fillable = ['numero_lot', 'nombre_tantiemes', 'id_copropriete', 'statut'];
    protected $casts = ['statut' => 'boolean', 'nombre_tantiemes' => 'integer'];

    public function copropriete(): BelongsTo
    {
        return $this->belongsTo(Copropriete::class, 'id_copropriete');
    }

    /**
     * Les propriétaires qui possèdent ce lot.
     */
    public function proprietaires(): BelongsToMany
    {
        return $this->belongsToMany(Proprietaire::class, 'lot_proprietaire', 'id_lot', 'id_proprietaire')
            ->withPivot('pourcentage_possession')
            ->withTimestamps(); // Optionnel: si la table pivot a des timestamps
    }
}
