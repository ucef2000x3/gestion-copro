<?php
namespace App\Models;
use App\Models\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompteBancaire extends Model {
    use HasFactory, HasStatus;
    protected $table = 'comptes_bancaires';
    protected $primaryKey = 'id_compte_bancaire';
    protected $fillable = ['id_copropriete', 'type_compte', 'nom_compte', 'iban', 'nom_banque', 'compte_comptable', 'solde_initial', 'statut'];
    protected $casts = ['solde_initial' => 'decimal:2'];

    public function copropriete(): BelongsTo {
        return $this->belongsTo(Copropriete::class, 'id_copropriete', 'id_copropriete');
    }
}
