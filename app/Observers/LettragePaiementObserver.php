<?php

namespace App\Observers;

use App\Models\EcritureComptable;
use App\Models\LettragePaiement;
use LogicException;

class LettragePaiementObserver
{
    /**
     * Gérer l'événement "created" du modèle LettragePaiement.
     */
    public function created(LettragePaiement $lettrage): void
    {
        $lettrage->load('reglementProprietaire.proprietaire', 'reglementProprietaire.compteBancaire', 'appelDeFond.exercice.copropriete');

        $reglement = $lettrage->reglementProprietaire;
        $appelDeFond = $lettrage->appelDeFond;

        // Sécurités
        if (!$reglement || !$appelDeFond || !$reglement->compteBancaire || !$reglement->proprietaire || !$appelDeFond->exercice) {
            throw new LogicException("Des informations essentielles sont manquantes pour le lettrage ID {$lettrage->id}.");
        }

        $proprietaire = $reglement->proprietaire;
        $exercice = $appelDeFond->exercice;
        $copropriete = $exercice->copropriete;

        $compteBanque = $reglement->compteBancaire->compte_comptable;
        $compteProprietaire = $proprietaire->compte_comptable ?? '450000';
        $libelle = "Règlement {$proprietaire->nom} / Lettrage sur {$appelDeFond->libelle}";

        // Écriture au débit de la banque (l'argent entre)
        EcritureComptable::create([
            'id_exercice' => $exercice->id_exercice,
            'id_copropriete' => $copropriete->id_copropriete,
            'documentable_id' => $lettrage->id,
            'documentable_type' => LettragePaiement::class,
            'numero_compte' => $compteBanque,
            'libelle' => $libelle,
            'debit' => $lettrage->montant_affecte,
            'credit' => null,
            'date_ecriture' => $reglement->date_reglement,
        ]);

        // Écriture au crédit du compte du propriétaire (sa dette diminue)
        EcritureComptable::create([
            'id_exercice' => $exercice->id_exercice,
            'id_copropriete' => $copropriete->id_copropriete,
            'documentable_id' => $lettrage->id,
            'documentable_type' => LettragePaiement::class,
            'numero_compte' => $compteProprietaire,
            'libelle' => $libelle,
            'debit' => null,
            'credit' => $lettrage->montant_affecte,
            'date_ecriture' => $reglement->date_reglement,
        ]);
    }
}
