<?php

namespace App\Policies;

use App\Models\Facture;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FacturePolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des factures.
     * C'est une permission générale.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('facture:voir');
    }

    /**
     * Détermine si l'utilisateur peut voir une facture spécifique.
     * La vérification se fait sur la copropriété parente de la facture.
     */
    public function view(User $user, Facture $facture): bool
    {
        return $user->hasPermissionTo('facture:voir', $facture->copropriete);
    }

    /**
     * Détermine si l'utilisateur peut créer des factures.
     * C'est une permission générale.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('facture:creer');
    }

    /**
     * Détermine si l'utilisateur peut modifier une facture.
     * La vérification se fait sur la copropriété parente de la facture.
     */
    public function update(User $user, Facture $facture): bool
    {
        return $user->hasPermissionTo('facture:modifier', $facture->copropriete);
    }

    /**
     * Détermine si l'utilisateur peut supprimer une facture.
     * La vérification se fait sur la copropriété parente de la facture.
     */
    public function delete(User $user, Facture $facture): bool
    {
        return $user->hasPermissionTo('facture:supprimer', $facture->copropriete);
    }

    /**
     * Détermine si l'utilisateur peut valider une facture.
     * C'est une permission spéciale, vérifiée sur le contexte de la copropriété.
     */
    public function valider(User $user, Facture $facture): bool
    {
        return $user->hasPermissionTo('facture:valider', $facture->copropriete);
    }

    /**
     * Détermine si l'utilisateur peut payer une facture.
     * C'est une permission spéciale, vérifiée sur le contexte de la copropriété.
     */
    public function payer(User $user, Facture $facture): bool
    {
        return $user->hasPermissionTo('facture:payer', $facture->copropriete);
    }
}
