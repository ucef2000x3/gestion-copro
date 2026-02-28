<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppelDeFonds extends Model
{
    use HasFactory;
    protected $table = 'appels_de_fonds';
    protected $primaryKey = 'id_appel_de_fond';
    protected $fillable = ['id_lot', 'id_exercice', 'libelle', 'montant_total_lot', 'date_appel', 'date_echeance', 'statut'];
    protected $casts = ['date_appel' => 'date', 'date_echeance' => 'date', 'montant_total_lot' => 'decimal:2'];

    public function lot(): BelongsTo { return $this->belongsTo(Lot::class, 'id_lot', 'id_lot'); }
    public function exercice(): BelongsTo { return $this->belongsTo(Exercice::class, 'id_exercice', 'id_exercice'); }

    // NOUVELLE RELATION : Un appel de fonds a plusieurs lignes de détail
    public function details(): HasMany
    {
        return $this->hasMany(AppelDeFondDetail::class, 'id_appel_de_fond', 'id_appel_de_fond');
    }


}
