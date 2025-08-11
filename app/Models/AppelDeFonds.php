<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppelDeFonds extends Model
{
    use HasFactory;
    protected $table = 'appels_de_fonds';
    protected $primaryKey = 'id_appel_de_fond';
    protected $fillable = ['id_lot', 'id_exercice', 'libelle', 'montant_appele', 'date_appel', 'date_echeance', 'statut'];
    protected $casts = ['date_appel' => 'date', 'date_echeance' => 'date', 'montant_appele' => 'decimal:2'];

    public function lot(): BelongsTo { return $this->belongsTo(Lot::class, 'id_lot'); }
    public function exerciceComptable(): BelongsTo { return $this->belongsTo(ExerciceComptable::class, 'id_exercice'); }
}
