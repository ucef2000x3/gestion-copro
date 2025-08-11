<?php
namespace App\Models;
use App\Enums\StatutExercice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExerciceComptable extends Model
{
    use HasFactory;
    protected $table = 'exercices_comptables'; // Bonne pratique de spécifier le nom de la table
    protected $primaryKey = 'id_exercice';
    protected $fillable = ['id_copropriete', 'libelle', 'date_debut', 'date_fin', 'statut'];
    protected $casts = ['date_debut' => 'date', 'date_fin' => 'date', 'statut' => StatutExercice::class,];

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

    /**
     * Récupère toutes les factures enregistrées durant cet exercice.
     */
    public function factures(): HasMany
    {
        return $this->hasMany(Facture::class, 'id_exercice');
    }

    // ... dans la classe ExerciceComptable
    public function appelsDeFonds(): HasMany
    {
        return $this->hasMany(AppelDeFonds::class, 'id_exercice');
    }
}
