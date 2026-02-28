<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MouvementTresorerie extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $table = 'mouvement_tresoreries';
    protected $guarded = [];

    /**
     * Obtenir le modèle parent (source) du mouvement.
     */
    public function sourceable(): MorphTo
    {
        return $this->morphTo();
    }
}
