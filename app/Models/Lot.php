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
    protected $fillable = ['numero_lot', 'nombre_tantiemes', 'id_residence', 'statut'];
    protected $casts = ['statut' => 'boolean', 'nombre_tantiemes' => 'integer'];

    public function residences(): BelongsTo
    {
        return $this->belongsTo(Residence::class, 'id_residence');
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

    public function residence(): BelongsTo
    {
        // On précise la clé étrangère que la relation doit utiliser.
        return $this->belongsTo(Residence::class, 'id_residence');
    }

    // ... dans la classe Lot
    public function appelsDeFonds(): HasMany
    {
        return $this->hasMany(AppelDeFonds::class, 'id_lot');
    }
}
