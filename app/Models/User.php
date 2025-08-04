<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_langue_preferee', // Permet la sauvegarde de la langue depuis le profil
        'is_super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Indique à Laravel que ce champ est un booléen
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_super_admin' => 'boolean', // <<<--- AJOUTEZ CETTE LIGNE
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Définit la relation : Un Utilisateur a une Langue préférée.
     */
    public function langue(): BelongsTo
    {
        return $this->belongsTo(Langue::class, 'id_langue_preferee');
    }

    /**
     * Les rôles qui appartiennent à l'utilisateur.
     * Définit la relation Plusieurs-à-Plusieurs avec le modèle Role.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'utilisateur_role', 'user_id', 'id_role');
    }

    /**
     * Vérifie si l'utilisateur a une permission, en tenant compte du périmètre (contexte).
     * Version finale avec correction de la faute de frappe.
     *
     * @param string $permissionCle La clé de la permission à vérifier.
     * @param \Illuminate\Database\Eloquent\Model|null $model Le modèle sur lequel la permission est testée.
     * @return bool
     */
    public function hasPermissionTo(string $permissionCle, $model = null): bool
    {
        $this->loadMissing(['roles.permissions', 'affectations.role.permissions']);

        // 1. Vérification des RÔLES GLOBAUX
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('cle', $permissionCle)) {
                return true;
            }
        }

        // Si on a un modèle, on continue avec la logique contextuelle
        if ($model) {
            // 2. Vérification des AFFECTATIONS SPÉCIFIQUES
            foreach ($this->affectations as $affectation) {
                if ($affectation->role && $affectation->role->permissions->contains('cle', $permissionCle)) {
                    // ... (toute la logique de remontée hiérarchique reste la même)
                    // Cas 1: Direct match
                    if ($affectation->affectable_type === get_class($model) && $affectation->affectable_id === $model->getKey()) return true;
                    // Cas 2: Parent match
                    if ($model instanceof \App\Models\Copropriete) {
                        if ($affectation->affectable_type === \App\Models\Syndic::class && $affectation->affectable_id === $model->id_syndic) return true;
                    }
                }
            }
        } else {
            // NOUVELLE LOGIQUE POUR `viewAny`
            // Si on n'a pas de modèle, on doit quand même vérifier si une affectation donne ce droit.
            // Cela permet de savoir si on doit afficher le lien du menu.
            foreach ($this->affectations as $affectation) {
                if ($affectation->role && $affectation->role->permissions->contains('cle', $permissionCle)) {
                    return true; // L'utilisateur a cette permission quelque part.
                }
            }
        }

        return false;
    }


    /**
     * (Optionnel) Une méthode pour vérifier si l'utilisateur a un rôle spécifique.
     *
     * @param string $roleName Le nom du rôle en français (ou autre langue par défaut).
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        $defaultLocale = config('app.fallback_locale', 'fr');
        foreach ($this->roles as $role) {
            if ($role->nom_role[$defaultLocale] === $roleName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Vérifie si l'utilisateur est un Super Administrateur.
     * La logique est maintenant beaucoup plus simple et directe.
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }

    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class, 'id_utilisateur');
    }

    // ... dans la classe User

    /**
     * Trouve le rôle le plus pertinent d'un utilisateur pour un modèle donné.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @return \App\Models\Role|null
     */
    public function getRoleFor($model = null): ?Role
    {
        if (!$model) {
            return null; // Pas de contexte, pas de rôle spécifique.
        }

        $this->loadMissing(['roles', 'affectations.role']);

        // 1. Cherche une affectation DIRECTE sur le modèle
        $directAffectation = $this->affectations
            ->where('affectable_type', get_class($model))
            ->where('affectable_id', $model->getKey())
            ->first();

        if ($directAffectation) {
            return $directAffectation->role;
        }

        // 2. Cherche une affectation sur le PARENT (remontée hiérarchique)
        $parent = null;
        if ($model instanceof \App\Models\Copropriete) {
            $parent = $model->syndic;
        } elseif ($model instanceof \App\Models\Residence) {
            $parent = $model->residence;
        }
        // ... (ajouter d'autres logiques de parenté si nécessaire)

        if ($parent) {
            $parentAffectation = $this->affectations
                ->where('affectable_type', get_class($parent))
                ->where('affectable_id', $parent->getKey())
                ->first();

            if ($parentAffectation) {
                return $parentAffectation->role;
            }
        }

        // (On pourrait ajouter la remontée sur le grand-parent ici)

        // 3. Si aucun rôle spécifique n'est trouvé, retourne le premier rôle GLOBAL
        // C'est une simplification, on pourrait retourner une liste.
        return $this->roles->first();
    }

    /**
     * Récupère le profil propriétaire associé à cet utilisateur.
     * C'est la relation inverse de Proprietaire->utilisateur().
     */
    public function proprietaire(): HasOne
    {
        // Un User A UN (hasOne) profil Proprietaire.
        // La clé étrangère est 'id_utilisateur' dans la table 'proprietaires'.
        return $this->hasOne(Proprietaire::class, 'id_utilisateur');
    }



}
