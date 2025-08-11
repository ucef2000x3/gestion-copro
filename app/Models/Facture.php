<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Facture extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_facture';
    protected $fillable = [
        'id_syndic', 'id_fournisseur', 'id_copropriete', 'id_exercice', 'id_budget_poste',
        'numero_facture', 'objet', 'statut', 'date_emission',
        'date_echeance', 'montant_ht', 'montant_tva', 'montant_ttc'
    ];
    protected $casts = [
        'date_emission' => 'date',
        'date_echeance' => 'date',
        'montant_ht' => 'decimal:2',
        'montant_tva' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
    ];

    public function syndic(): BelongsTo { return $this->belongsTo(Syndic::class, 'id_syndic'); }
    public function fournisseur(): BelongsTo { return $this->belongsTo(Fournisseur::class, 'id_fournisseur'); }
    public function copropriete(): BelongsTo { return $this->belongsTo(Copropriete::class, 'id_copropriete'); }
    public function exerciceComptable(): BelongsTo { return $this->belongsTo(ExerciceComptable::class, 'id_exercice'); }
    public function budgetPostes(): BelongsToMany
    {
        return $this->belongsToMany(
            BudgetPoste::class,
            'imputations_facture', // Nom de la table pivot
            'id_facture',          // Clé étrangère de CE modèle dans la table pivot
            'id_poste'             // Clé étrangère de l'AUTRE modèle
        )->withPivot('montant_impute')->withTimestamps(); // On récupère la colonne supplémentaire
    }
    /**
     * Gère l'imputation analytique (multi-postes)
     */
    public function imputations(): BelongsToMany
    {
        return $this->belongsToMany(BudgetPoste::class, 'imputations_facture', 'id_facture', 'id_poste')
            ->withPivot('montant_impute')->withTimestamps();
    }
}
