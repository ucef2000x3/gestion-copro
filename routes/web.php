<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SyndicController;
use App\Http\Controllers\Admin\CoproprieteController;
use App\Http\Controllers\Admin\ResidenceController;
use App\Http\Controllers\Admin\LotController;
use App\Http\Controllers\Admin\ProprietaireController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserAffectationController;
use App\Http\Controllers\Admin\LotProprietaireController;
use App\Http\Controllers\Admin\ExerciceComptableController;
use App\Http\Controllers\Admin\TypeDePosteController;
use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Admin\FournisseurController;
use App\Http\Controllers\Admin\FactureController;
use App\Http\Controllers\Admin\GenerationAppelFondsController;
use App\Http\Controllers\Admin\AppelDeFondsController;
use App\Http\Controllers\Admin\FactureImputationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route pour la page d'accueil publique

Route::get('/', function () {
    return view('welcome');
});

// Route pour le tableau de bord principal, protégée par défaut par Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/test-lang', function () {
    // Force l'application à être en français pour ce test
    App::setLocale('fr');

    // Affiche des informations de débogage et arrête l'exécution
    dd(
        'Langue définie via config/app.php :', config('app.locale'),
        'Langue de secours (fallback) :', config('app.fallback_locale'),
        'Langue actuelle de l\'application :', App::getLocale(),
        'Traduction pour "Dashboard" :', __('Dashboard'),
        'Traduction pour "validation.required" :', __('validation.required')
    );
});

// Groupe de toutes les routes qui nécessitent que l'utilisateur soit authentifié
Route::middleware('auth')->group(function () {

    // --- Routes de Profil ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ===================================================================
    // == SECTION POUR VOS ROUTES DE GESTION (ADMINISTRATION) ==
    // ===================================================================

    // --- CRUDs Principaux ---
    Route::resource('/admin/syndics', SyndicController::class);
    Route::resource('/admin/coproprietes', CoproprieteController::class);
    // (Nous ajouterons les copropriétés et les lots ici plus tard)


    // --- Gestion des Utilisateurs et des Permissions ---
    Route::resource('/admin/roles', RoleController::class);
    Route::resource('/admin/permissions', PermissionController::class);
    Route::resource('/admin/users', UserController::class)->except(['create', 'store']); // On exclut create/store car géré par Breeze

    // --- Gestion des Affectations (liées à un utilisateur) ---
    // Note: Ces routes sont imbriquées dans l'URL des utilisateurs pour la clarté.
    Route::post('/admin/users/{user}/affectations', [UserAffectationController::class, 'store'])->name('users.affectations.store');
    Route::delete('/admin/users/{user}/affectations/{affectation}', [UserAffectationController::class, 'destroy'])->name('users.affectations.destroy');
    //gestion des copropriétés
    Route::resource('/admin/residences', ResidenceController::class);
    //gestion des lots
    Route::resource('/admin/lots', LotController::class);
    // Gestion des propriétaires
    Route::resource('/admin/proprietaires', ProprietaireController::class);
    // GÉRER LA RELATION LOT-PROPRIO ==
    // =========================================================
    Route::post('/admin/lots/{lot}/proprietaires', [LotProprietaireController::class, 'store'])->name('lots.proprietaires.store');
    Route::patch('/admin/lots/{lot}/proprietaires/{proprietaire}', [LotProprietaireController::class, 'update'])->name('lots.proprietaires.update');
    Route::delete('/admin/lots/{lot}/proprietaires/{proprietaire}', [LotProprietaireController::class, 'destroy'])->name('lots.proprietaires.destroy');
    Route::resource('/admin/exercices', ExerciceComptableController::class);
    Route::resource('/admin/types-de-poste', TypeDePosteController::class)->names('types-de-poste');

    Route::get('/admin/exercices/{exercice}/budget', [BudgetController::class, 'index'])->name('exercices.budget.index');
    Route::post('/admin/exercices/{exercice}/budget', [BudgetController::class, 'store'])->name('exercices.budget.store');
    Route::delete('/admin/budget-postes/{poste}', [BudgetController::class, 'destroy'])->name('budget-postes.destroy');
    Route::resource('/admin/fournisseurs', FournisseurController::class);
    Route::resource('/admin/factures', FactureController::class);

    // Route pour la liste des appels de fonds
    Route::get('/admin/appels-de-fonds', [AppelDeFondsController::class, 'index'])->name('appels-de-fonds.index');
    // Affiche la page avec le formulaire de génération
    Route::get('/admin/exercices/{exercice}/generer-appels', [GenerationAppelFondsController::class, 'create'])->name('exercices.appels.create');
    // Traite la soumission du formulaire et génère les appels
    Route::post('/admin/exercices/{exercice}/generer-appels', [GenerationAppelFondsController::class, 'store'])->name('exercices.appels.store');
    // Route pour sauvegarder l'ensemble de l'imputation d'une facture
    Route::post('/admin/factures/{facture}/imputations', [FactureImputationController::class, 'store'])->name('factures.imputations.store');

    Route::get('/api/coproprietes/{copropriete}/exercices-ouverts', function (\App\Models\Copropriete $copropriete) {
        if (auth()->user()->cannot('view', $copropriete)) {
            abort(403);
        }

        // CORRECTION : On charge les exercices ET, pour chaque exercice,
        // on charge ses postes budgétaires avec le libellé du type de poste.
        $exercices = $copropriete->exercicesComptables()
            ->where('statut', \App\Enums\StatutExercice::Ouvert)
            ->with('budgetPostes.typeDePoste') // <<<--- LIGNE AJOUTÉE/MODIFIÉE
            ->orderBy('date_debut', 'desc')
            ->get();

        return response()->json($exercices);
    })->name('api.coproprietes.exercices');

    // Route N°2 : Récupère les postes budgétaires pour un exercice
    Route::get('/api/exercices/{exercice}/budget-postes', function (\App\Models\ExerciceComptable $exercice) {
        if (auth()->user()->cannot('view', $exercice->copropriete)) abort(403);

        $postes = $exercice->budgetPostes()->with('typeDePoste')->get();

        return response()->json($postes);
    })->name('api.exercices.budget-postes');
});


// Fichier qui contient toutes les routes liées à l'authentification (généré par Breeze)
require __DIR__.'/auth.php';
