<?php
namespace App\Models;
use App\Models\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devise extends Model
{
    use HasFactory, HasStatus;
    protected $table = 'devises';
    protected $primaryKey = 'id_devise';
    protected $fillable = ['nom', 'code', 'symbole', 'statut'];

    public function coproprietes(): HasMany
    {
        return $this->hasMany(Copropriete::class, 'id_devise');
    }
}
