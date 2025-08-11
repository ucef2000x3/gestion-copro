<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BudgetPoste extends Model
{
    use HasFactory;
    protected $table = 'budget_postes';
    protected $primaryKey = 'id_poste';
    protected $fillable = ['id_exercice', 'id_type_poste', 'montant_previsionnel'];
    protected $casts = ['montant_previsionnel' => 'decimal:2'];

    public function exerciceComptable(): BelongsTo
    {
        return $this->belongsTo(ExerciceComptable::class, 'id_exercice');
    }

    public function typeDePoste(): BelongsTo
    {
        return $this->belongsTo(TypeDePoste::class, 'id_type_poste');
    }

    public function factures(): BelongsToMany
    {
        return $this->belongsToMany(
            Facture::class,
            'imputations_facture', // Nom de la table pivot
            'id_poste',            // Clé étrangère de CE modèle
            'id_facture'           // Clé étrangère de l'AUTRE modèle
        )->withPivot('montant_impute')->withTimestamps();
    }
}
