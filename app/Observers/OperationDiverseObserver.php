<?php

namespace App\Observers;

use App\Models\EcritureComptable;
use App\Models\MouvementTresorerie;
use App\Models\OperationDiverse;
use Illuminate\Support\Facades\DB;
use LogicException;

class OperationDiverseObserver
{
    /**
     * Gérer l'événement "created" du modèle OperationDiverse.
     */
    public function created(OperationDiverse $operation): void
    {
        DB::transaction(function () use ($operation) {
            $operation->load('copropriete', 'exercice', 'typeDePoste', 'compteBancaire');

            // Sécurités
            if (!$operation->compteBancaire || !$operation->typeDePoste || !$operation->exercice) {
                throw new LogicException("Des informations essentielles (compte bancaire, poste ou exercice) sont manquantes pour l'Opération Diverse ID {$operation->id_operation_diverse}.");
            }

            // ===== 1. CRÉATION DU MOUVEMENT DE TRÉSORERIE =====
            MouvementTresorerie::create([
                'id_copropriete' => $operation->id_copropriete,
                'sourceable_id' => $operation->id_operation_diverse,
                'sourceable_type' => OperationDiverse::class,
                'type' => $operation->typeDePoste->nature === 'charge' ? 'decaissement' : 'encaissement',
                'montant' => $operation->montant,
                'libelle' => $operation->libelle,
                'date_mouvement' => $operation->date_operation,
            ]);

            // ===== 2. CRÉATION DES ÉCRITURES COMPTABLES =====
            $compteBanque = $operation->compteBancaire->compte_comptable;
            $compteContrepartie = $operation->typeDePoste->code_comptable;

            // Définition du débit et du crédit en fonction de la nature du poste
            if ($operation->typeDePoste->nature === 'charge') {
                // Pour une dépense, on débite le compte de charge et on crédite la banque
                $debitBanque = null;
                $creditBanque = $operation->montant;
                $debitContrepartie = $operation->montant;
                $creditContrepartie = null;
            } else { // 'produit'
                // Pour une recette, on débite la banque et on crédite le compte de produit
                $debitBanque = $operation->montant;
                $creditBanque = null;
                $debitContrepartie = null;
                $creditContrepartie = $operation->montant;
            }

            // Écriture pour la banque
            EcritureComptable::create([
                'id_exercice' => $operation->id_exercice, 'id_copropriete' => $operation->id_copropriete,
                'documentable_id' => $operation->id_operation_diverse, 'documentable_type' => OperationDiverse::class,
                'numero_compte' => $compteBanque, 'libelle' => $operation->libelle,
                'debit' => $debitBanque, 'credit' => $creditBanque,
                'date_ecriture' => $operation->date_operation,
            ]);

            // Écriture pour la contrepartie (charge ou produit)
            EcritureComptable::create([
                'id_exercice' => $operation->id_exercice, 'id_copropriete' => $operation->id_copropriete,
                'documentable_id' => $operation->id_operation_diverse, 'documentable_type' => OperationDiverse::class,
                'numero_compte' => $compteContrepartie, 'libelle' => $operation->libelle,
                'debit' => $debitContrepartie, 'credit' => $creditContrepartie,
                'date_ecriture' => $operation->date_operation,
            ]);
        });
    }
}
