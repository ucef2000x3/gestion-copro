<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory, HasTranslations;

    protected $primaryKey = 'id_role';

    /**
     * The attributes that should be cast to native types.
     * Indique à Laravel de traiter automatiquement la colonne 'nom_role'
     * comme un tableau PHP lors de la lecture et comme une chaîne JSON lors de l'écriture.
     * @var array
     */
    protected $casts = [
        'nom_role' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_role',
    ];


    /**
     * The permissions that belong to the role.
     * Définit une relation Plusieurs-à-Plusieurs (belongsToMany) avec le modèle Permission.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_has_permission', // Nom de la table pivot
            'id_role',             // Clé étrangère de CE modèle dans la table pivot
            'id_permission'        // Clé étrangère de l'AUTRE modèle dans la table pivot
        );
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'utilisateur_role', 'id_role', 'user_id');
    }
}
