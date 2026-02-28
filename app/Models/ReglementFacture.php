<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
class ReglementFacture extends Model {
    use HasFactory;
    protected $table = 'reglements_factures';
    protected $primaryKey = 'id_reglement';
    protected $fillable = ['id_facture', 'id_exercice', 'id_compte_bancaire', 'montant_regle', 'date_reglement', 'mode_de_reglement', 'reference_reglement'];
    protected $casts = ['date_reglement' => 'date', 'montant_regle' => 'decimal:2'];
    public function facture(): BelongsTo { return $this->belongsTo(Facture::class, 'id_facture', 'id_facture'); }
    public function exercice(): BelongsTo { return $this->belongsTo(Exercice::class, 'id_exercice', 'id_exercice'); }
    /**
     * Obtenir toutes les écritures comptables pour ce règlement.
     */
    public function ecrituresComptables(): MorphMany
    {
        return $this->morphMany(EcritureComptable::class, 'documentable');
    }

    /**
     * Obtenir le mouvement de trésorerie pour ce règlement.
     */
    public function mouvementTresorerie(): MorphMany
    {
        return $this->morphMany(MouvementTresorerie::class, 'sourceable');
    }

    public function compteBancaire(): BelongsTo {
        return $this->belongsTo(CompteBancaire::class, 'id_compte_bancaire', 'id_compte_bancaire');
    }
}
