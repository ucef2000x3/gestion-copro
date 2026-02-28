<?php

namespace App\Observers;

use App\Models\EcritureComptable;
use App\Models\MouvementTresorerie;
use App\Models\ReglementFacture;
use Illuminate\Support\Facades\DB;
use LogicException;

class ReglementFactureObserver
{
    /**
     * Gérer l'événement "created" (création) du modèle ReglementFacture.
     */
    public function created(ReglementFacture $reglement): void
    {
        DB::transaction(function () use ($reglement) {
            // Charger toutes les relations nécessaires en une seule fois pour optimiser
            $reglement->load('facture.copropriete', 'facture.fournisseur', 'facture.exercice', 'compteBancaire');

            $facture = $reglement->facture;

            // Sécurités pour garantir l'intégrité des données
            if (!$reglement->compteBancaire || !$facture || !$facture->fournisseur || !$facture->exercice) {
                throw new LogicException("Des informations essentielles (compte bancaire, facture, fournisseur ou exercice) sont manquantes pour le règlement ID {$reglement->id_reglement}.");
            }

            // ===== 1. CRÉATION DU MOUVEMENT DE TRÉSORERIE =====
            MouvementTresorerie::create([
                'id_copropriete' => $facture->id_copropriete,
                'sourceable_id' => $reglement->id_reglement,
                'sourceable_type' => ReglementFacture::class,
                'type' => 'decaissement',
                'montant' => $reglement->montant_regle,
                'libelle' => "Paiement Facture N°{$facture->numero_facture} - {$facture->fournisseur->nom}",
                'date_mouvement' => $reglement->date_reglement,
            ]);

            // ===== 2. CRÉATION DES ÉCRITURES COMPTABLES (PARTIE DOUBLE) =====
            $compteBanque = $reglement->compteBancaire->compte_comptable;
            $compteFournisseur = $facture->fournisseur->compte_comptable ?? '401000'; // Utilise le compte spécifique du fournisseur, ou 401000 par défaut
            $libelle = "Règlement Facture N°{$facture->numero_facture} / {$facture->fournisseur->nom}";

            // Écriture au débit du compte fournisseur (on solde la dette)
            EcritureComptable::create([
                'id_exercice' => $reglement->id_exercice,
                'id_copropriete' => $facture->id_copropriete,
                'documentable_id' => $reglement->id_reglement,
                'documentable_type' => ReglementFacture::class,
                'numero_compte' => $compteFournisseur,
                'libelle' => $libelle,
                'debit' => $reglement->montant_regle,
                'credit' => null,
                'date_ecriture' => $reglement->date_reglement,
            ]);

            // Écriture au crédit du compte de banque (l'argent sort)
            EcritureComptable::create([
                'id_exercice' => $reglement->id_exercice,
                'id_copropriete' => $facture->id_copropriete,
                'documentable_id' => $reglement->id_reglement,
                'documentable_type' => ReglementFacture::class,
                'numero_compte' => $compteBanque,
                'libelle' => $libelle,
                'debit' => null,
                'credit' => $reglement->montant_regle,
                'date_ecriture' => $reglement->date_reglement,
            ]);
        });
    }
}
