<?php

namespace App\Enums;

// On déclare un "Backed Enum" de type `int`.
// Chaque cas aura une valeur entière correspondante, stockée en base de données.
enum StatutExercice: int
{
    case Ouvert = 1;
    case Planifie = 2; // "Planifié" avec accent n'est pas un nom de case valide
    case Cloture = 3;  // "Clôturé" non plus

    /**
     * Retourne une étiquette lisible pour l'affichage dans l'interface.
     */
    public function label(): string
    {
        return match($this) {
            self::Ouvert => 'Ouvert',
            self::Planifie => 'Planifié',
            self::Cloture => 'Clôturé',
        };
    }
}
