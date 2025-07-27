<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExerciceComptable extends Model
{
    use HasFactory;
    protected $table = 'exercices_comptables'; // Bonne pratique de spécifier le nom de la table
    protected $primaryKey = 'id_exercice';
    protected $fillable = ['id_copropriete', 'date_debut', 'date_fin', 'statut'];
    protected $casts = ['date_debut' => 'date', 'date_fin' => 'date'];

    public function copropriete(): BelongsTo
    {
        return $this->belongsTo(Copropriete::class, 'id_copropriete');
    }
}
