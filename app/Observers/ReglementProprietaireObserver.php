<?php
namespace App\Observers;
use App\Models\MouvementTresorerie;
use App\Models\ReglementProprietaire;

class ReglementProprietaireObserver
{
    public function created(ReglementProprietaire $reglement): void
    {
        $reglement->load('proprietaire', 'exercice.copropriete');

        $exercice = $reglement->exercice;
        if (!$exercice || !$exercice->copropriete) return;

        MouvementTresorerie::create([
            'id_copropriete' => $exercice->copropriete->id_copropriete,
            'sourceable_id' => $reglement->id_reglement_proprio,
            'sourceable_type' => ReglementProprietaire::class,
            'type' => 'encaissement',
            'montant' => $reglement->montant_regle,
            'libelle' => "Paiement de {$reglement->proprietaire->nom} {$reglement->proprietaire->prenom}",
            'date_mouvement' => $reglement->date_reglement,
        ]);
    }
}
