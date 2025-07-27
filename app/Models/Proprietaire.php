<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Concerns\HasStatus;

class Proprietaire extends Model
{
    use HasFactory, HasStatus;

    protected $primaryKey = 'id_proprietaire';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_utilisateur',
        'type_proprietaire',
        'nom',
        'email',
        'telephone_contact',
        'adresse_postale',
        'code_postal',
        'ville',
        'pays',
        'civilite',
        'prenom',
        'date_naissance',
        'forme_juridique',
        'numero_siret',
        'iban',
        'bic',
        'commentaires',
        'statut',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'statut' => 'boolean',
        'date_naissance' => 'date',
    ];

    /**
     * Récupère le compte utilisateur associé à ce propriétaire.
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    /**
     * Les lots qui appartiennent à ce propriétaire.
     * (Relation Plusieurs-à-Plusieurs)
     */
    public function lots(): BelongsToMany
    {
        return $this->belongsToMany(Lot::class, 'lot_proprietaire', 'id_proprietaire', 'id_lot')
            ->withPivot('pourcentage_possession') // <<<--- AJOUTEZ CETTE LIGNE
            ->withTimestamps();
    }
}
