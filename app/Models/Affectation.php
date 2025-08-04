<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Affectation extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_affectation';

    protected $fillable = [
        'id_utilisateur',
        'id_role',
        'affectable_type',
        'affectable_id',
    ];

    /**
     * Récupère le modèle parent de l'affectation (un Syndic, une Copropriete, etc.).
     */
    public function affectable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Récupère le rôle associé à cette affectation.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    /**
     * Récupère l'utilisateur associé à cette affectation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }
}
