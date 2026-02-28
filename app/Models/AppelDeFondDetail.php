<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AppelDeFondDetail extends Model // <<< Le nom de la classe doit être AppelDeFondDetail
{
    use HasFactory;
    protected $table = 'appel_de_fond_details';
    protected $guarded = [];

    public function appelDeFond(): BelongsTo
    {
        return $this->belongsTo(AppelDeFonds::class, 'id_appel_de_fond', 'id_appel_de_fond');
    }

    public function proprietaire(): BelongsTo
    {
        return $this->belongsTo(Proprietaire::class, 'id_proprietaire', 'id_proprietaire');
    }

    public function reglementsLettres(): BelongsToMany
    {
        return $this->belongsToMany(ReglementProprietaire::class, 'lettrage_paiements', 'id_appel_de_fond_detail', 'id_reglement_proprio')
            ->withPivot('montant_affecte')->withTimestamps();
    }
}
