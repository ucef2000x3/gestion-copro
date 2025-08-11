<?php
namespace App\Models;
use App\Models\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TypeDePoste extends Model
{
    use HasFactory, HasStatus;
    protected $table = 'types_de_poste';
    protected $primaryKey = 'id_type_poste';
    protected $fillable = ['id_copropriete', 'libelle', 'code_comptable', 'statut'];

    public function copropriete(): BelongsTo
    {
        return $this->belongsTo(Copropriete::class, 'id_copropriete');
    }

    /**
     * Récupère toutes les lignes de budget de cet exercice.
     */
    public function budgetPostes(): HasMany
    {
        return $this->hasMany(BudgetPoste::class, 'id_exercice');
    }
}
