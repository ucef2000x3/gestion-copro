<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperationDiverse extends Model
{
    use HasFactory;
    protected $table = 'operations_diverses';
    protected $primaryKey = 'id_operation_diverse';
    protected $fillable = ['id_copropriete', 'id_exercice', 'id_compte_bancaire', 'id_type_poste', 'type_operation', 'montant', 'libelle', 'date_operation', 'tiers'];
    protected $casts = ['date_operation' => 'date', 'montant' => 'decimal:2'];

    public function copropriete(): BelongsTo { return $this->belongsTo(Copropriete::class, 'id_copropriete', 'id_copropriete'); }
    public function exercice(): BelongsTo { return $this->belongsTo(Exercice::class, 'id_exercice', 'id_exercice'); }
    public function typeDePoste(): BelongsTo { return $this->belongsTo(TypeDePoste::class, 'id_type_poste', 'id_type_poste'); }
    public function compteBancaire(): BelongsTo {
        return $this->belongsTo(CompteBancaire::class, 'id_compte_bancaire', 'id_compte_bancaire');
    }
}
