<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// ===============================================
// == CORRECTION CRITIQUE : IMPORTER LA BONNE CLASSE
// ===============================================
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ReglementProprietaire extends Model
{
    use HasFactory;
    protected $table = 'reglements_proprietaires';
    protected $primaryKey = 'id_reglement_proprio';
    protected $fillable = ['id_proprietaire', 'id_exercice', 'id_compte_bancaire', 'montant_regle', 'date_reglement', 'mode_de_reglement', 'reference_paiement', 'statut'];
    protected $casts = ['date_reglement' => 'date', 'montant_regle' => 'decimal:2'];

    public function proprietaire(): BelongsTo { return $this->belongsTo(Proprietaire::class, 'id_proprietaire', 'id_proprietaire'); }
    public function exercice(): BelongsTo { return $this->belongsTo(Exercice::class, 'id_exercice', 'id_exercice'); }
    public function compteBancaire(): BelongsTo { return $this->belongsTo(CompteBancaire::class, 'id_compte_bancaire', 'id_compte_bancaire'); }

    public function appelDeFondDetailsLettres(): BelongsToMany
    {
        return $this->belongsToMany(AppelDeFondDetail::class, 'lettrage_paiements', 'id_reglement_proprio', 'id_appel_de_fond_detail')
            ->withPivot('montant_affecte')->withTimestamps();
    }

    // ===============================================
    // == CORRECTION CRITIQUE : LE TYPE DE RETOUR EST MAINTENANT CORRECT
    // ===============================================
    public function lettrages(): HasMany
    {
        return $this->hasMany(LettragePaiement::class, 'id_reglement_proprio', 'id_reglement_proprio');
    }

    public function ecrituresComptables(): MorphMany
    {
        return $this->morphMany(EcritureComptable::class, 'documentable');
    }

    public function mouvementsTresorerie(): MorphMany // Renommer cette méthode serait une bonne pratique
    {
        return $this->morphMany(MouvementTresorerie::class, 'sourceable');
    }
}
