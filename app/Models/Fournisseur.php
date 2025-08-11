<?php
namespace App\Models;
use App\Models\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fournisseur extends Model
{
    use HasFactory, HasStatus;
    protected $primaryKey = 'id_fournisseur';
    protected $fillable = ['nom', 'statut'];

    /**
     * Récupère toutes les factures émises par ce fournisseur.
     */
    public function factures(): HasMany
    {
        return $this->hasMany(Facture::class, 'id_fournisseur');
    }


}
