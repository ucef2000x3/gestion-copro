<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // <<<=== Utilisez le Model standard
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LettragePaiement extends Model // <<<=== La classe étend Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     */
    protected $table = 'lettrage_paiements';

    /**
     * Indique que le modèle a une clé primaire auto-incrémentée (c'est le comportement par défaut, mais il est bon d'être explicite).
     * @var bool
     */
    public $incrementing = true;

    /**
     * La clé primaire associée à la table.
     * @var string
     */
    protected $primaryKey = 'id'; // <<<=== Assurez-vous que c'est bien 'id'

    /**
     * Les attributs qui ne sont pas assignables en masse.
     * @var array
     */
    protected $guarded = [];


    public function appelDeFondDetail(): BelongsTo
    {
        // Renommons la méthode pour correspondre au champ de la BDD pour la clarté
        return $this->belongsTo(AppelDeFondDetail::class, 'id_appel_de_fond_detail', 'id');
    }

    public function reglementProprietaire(): BelongsTo
    {
        return $this->belongsTo(ReglementProprietaire::class, 'id_reglement_proprio', 'id_reglement_proprio');
    }
}
