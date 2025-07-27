<?php
namespace App\Models;
use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Permission extends Model
{
    use HasFactory, HasTranslations;
    protected $primaryKey = 'id_permission';
    protected $casts = [
        'nom_permission' => 'array',
    ];
    protected $fillable = [
        'cle',
        'nom_permission',
    ];

    /**
     * The roles that belong to the permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'role_has_permission', // Nom de la table pivot
            'id_permission',       // Clé étrangère de CE modèle dans la table pivot
            'id_role'              // Clé étrangère de l'AUTRE modèle dans la table pivot
        );
    }
}
