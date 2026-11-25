<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// AUTHENTIFICATION
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/connexion', [LoginController::class, 'store'])
        ->name('login.store');
});

// ESPACE UTILISATEUR PROTEGE
Route::middleware(['auth', 'active'])->group(function () {

    // DECONNEXION
    Route::post('/deconnexion', [LoginController::class, 'destroy'])
        ->name('logout');

    // TABLEAU DE BORD
    Route::view('/', 'dashboard')->name('dashboard');

    // GESTION DES CLIENTS
    Route::get('/clients', [ClientController::class, 'index'])
        ->name('clients.index');

    Route::get('/clients/create', [ClientController::class, 'create'])
        ->name('clients.create');

    Route::post('/clients', [ClientController::class, 'store'])
        ->name('clients.store');

    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])
        ->whereNumber('client')
        ->name('clients.edit');

    Route::put('/clients/{client}', [ClientController::class, 'update'])
        ->whereNumber('client')
        ->name('clients.update');

    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])
        ->whereNumber('client')
        ->name('clients.destroy');

    Route::patch('/clients/{id}/restore', [ClientController::class, 'restore'])
        ->whereNumber('id')
        ->name('clients.restore');

    Route::get('/clients/{client}', [ClientController::class, 'show'])
        ->whereNumber('client')
        ->name('clients.show');

    // MODULE RENDEZ-VOUS (VUE TEMPORAIRE)
   Route::get('/rendez-vous', [RendezVousController::class, 'index'])
    ->name('rendez-vous.index');
    Route::get('/rendez-vous/create', [RendezVousController::class, 'create'])
    ->name('rendez-vous.create');

    // MODULE RENDEZ-VOUS

    // Liste des rendez-vous
    Route::get('/rendez-vous', [RendezVousController::class, 'index'])
        ->name('rendez-vous.index');

    // Formulaire de création
    Route::get('/rendez-vous/create', [RendezVousController::class, 'create'])
        ->name('rendez-vous.create');

    // Enregistrement
    Route::post('/rendez-vous', [RendezVousController::class, 'store'])
        ->name('rendez-vous.store');

    // Consultation des détails
    Route::get('/rendez-vous/{rendezVous}', [RendezVousController::class, 'show'])
        ->whereNumber('rendezVous')
        ->name('rendez-vous.show');

    // Formulaire de modification
    Route::get('/rendez-vous/{rendezVous}/edit', [RendezVousController::class, 'edit'])
        ->whereNumber('rendezVous')
        ->name('rendez-vous.edit');

    // Enregistrement des modifications
    Route::put('/rendez-vous/{rendezVous}', [RendezVousController::class, 'update'])
        ->whereNumber('rendezVous')
        ->name('rendez-vous.update');

    // Annulation du rendez-vous
    Route::delete('/rendez-vous/{rendezVous}', [RendezVousController::class, 'destroy'])
        ->whereNumber('rendezVous')
        ->name('rendez-vous.destroy');

    // MODULE PRESTATIONS

    // Liste des prestations
    Route::get('/prestations', [ServiceController::class, 'index'])
        ->name('services.index');

    // Formulaire de création
    Route::get('/prestations/create', [ServiceController::class, 'create'])
        ->name('services.create');

    // Enregistrement
    Route::post('/prestations', [ServiceController::class, 'store'])
        ->name('services.store');

    // Formulaire de modification
    Route::get('/prestations/{service}/edit', [ServiceController::class, 'edit'])
        ->whereNumber('service')
        ->name('services.edit');

    // Mise à jour
    Route::put('/prestations/{service}', [ServiceController::class, 'update'])
        ->whereNumber('service')
        ->name('services.update');

    // Activation / désactivation
    Route::patch('/prestations/{service}/statut', [ServiceController::class, 'toggleStatus'])
        ->whereNumber('service')
        ->name('services.toggle-status');

});
