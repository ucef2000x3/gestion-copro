<?php

namespace App\Models\Concerns;

trait HasStatus
{
    /**
     * Scope a query to only include active models.
     * Permet de faire des requêtes plus lisibles comme: Model::actif()->get();
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActif($query)
    {
        return $query->where('statut', true);
    }

    /**
     * Vérifie si le statut du modèle est actif.
     * Permet de faire des vérifications comme: $model->isActif()
     */
    public function isActif(): bool
    {
        return $this->statut === true;
    }

    /**
     * Vérifie si le statut du modèle est inactif.
     * Permet de faire des vérifications comme: $model->isInactive()
     */
    public function isInactive(): bool
    {
        return !$this->isActif();
    }
}
