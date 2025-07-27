<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SyndicController;
use App\Http\Controllers\Admin\ResidenceController;
use App\Http\Controllers\Admin\CoproprieteController;
use App\Http\Controllers\Admin\LotController;
use App\Http\Controllers\Admin\ProprietaireController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserAffectationController;
use App\Http\Controllers\Admin\LotProprietaireController;


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
    Route::resource('/admin/residences', ResidenceController::class);
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
    Route::resource('/admin/coproprietes', CoproprieteController::class);
    //gestion des lots
    Route::resource('/admin/lots', LotController::class);
    // Gestion des propriétaires
    Route::resource('/admin/proprietaires', ProprietaireController::class);
    // GÉRER LA RELATION LOT-PROPRIO ==
    // =========================================================
    Route::post('/admin/lots/{lot}/proprietaires', [LotProprietaireController::class, 'store'])->name('lots.proprietaires.store');
    Route::patch('/admin/lots/{lot}/proprietaires/{proprietaire}', [LotProprietaireController::class, 'update'])->name('lots.proprietaires.update');
    Route::delete('/admin/lots/{lot}/proprietaires/{proprietaire}', [LotProprietaireController::class, 'destroy'])->name('lots.proprietaires.destroy');
});


// Fichier qui contient toutes les routes liées à l'authentification (généré par Breeze)
require __DIR__.'/auth.php';
