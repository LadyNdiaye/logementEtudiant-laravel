<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogementController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\DemandeVisiteController;

Route::get('/', function () {
    return redirect()->route('logements.index');
});

// Inscription et connexion (visiteurs non connectés)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Pages réservées aux utilisateurs connectés
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profil', [AuthController::class, 'editProfil'])->name('profil.edit');
    Route::put('/profil', [AuthController::class, 'updateProfil'])->name('profil.update');

    // Propriétaire
    Route::get('/mes-logements', [LogementController::class, 'mesLogements'])->name('logements.mes');
    Route::patch('/logements/{logement}/statut', [LogementController::class, 'changerStatut'])->name('logements.statut');
    Route::resource('logements', LogementController::class)->except(['index', 'show']);

    // Étudiant : favoris
    Route::get('/favoris', [FavoriController::class, 'index'])->name('favoris.index');
    Route::post('/favoris/{logement}', [FavoriController::class, 'store'])->name('favoris.store');
    Route::delete('/favoris/{logement}', [FavoriController::class, 'destroy'])->name('favoris.destroy');

    // Demandes de visite
    Route::get('/demandes', [DemandeVisiteController::class, 'index'])->name('demandes.index');
    Route::post('/logements/{logement}/demandes', [DemandeVisiteController::class, 'store'])->name('demandes.store');
    Route::patch('/demandes/{demande}/accepter', [DemandeVisiteController::class, 'accepter'])->name('demandes.accepter');
    Route::patch('/demandes/{demande}/refuser', [DemandeVisiteController::class, 'refuser'])->name('demandes.refuser');
});

// Consultation des logements (accessible à tous)
Route::resource('logements', LogementController::class)->only(['index', 'show']);
