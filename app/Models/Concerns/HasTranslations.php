<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\App;

trait HasTranslations
{
    /**
     * Récupère la traduction d'un attribut dans la langue actuelle,
     * avec un fallback sur la langue par défaut.
     *
     * @param string $attribute Le nom de la colonne JSON à traduire (ex: 'nom_role').
     * @return string|null
     */
    public function getTranslated(string $attribute): ?string
    {
        $currentLocale = App::getLocale();
        $fallbackLocale = config('app.fallback_locale', 'fr');

        // Tente de récupérer la traduction dans la langue actuelle
        if (isset($this->{$attribute}[$currentLocale]) && !empty($this->{$attribute}[$currentLocale])) {
            return $this->{$attribute}[$currentLocale];
        }

        // Si elle n'existe pas, tente de récupérer la traduction dans la langue de fallback
        if (isset($this->{$attribute}[$fallbackLocale]) && !empty($this->{$attribute}[$fallbackLocale])) {
            return $this->{$attribute}[$fallbackLocale];
        }

        // Si toujours rien, retourne la première traduction disponible ou une chaîne vide
        return reset($this->{$attribute}) ?: null;
    }
}
