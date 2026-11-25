<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

// Tableau de bord
Route::view('/', 'dashboard')->name('dashboard');

// Gestion des clients
Route::get('/clients', [ClientController::class, 'index'])
    ->name('clients.index');

// Formulaire d'ajout : avant {client}
Route::get('/clients/create', [ClientController::class, 'create'])
    ->name('clients.create');

Route::post('/clients', [ClientController::class, 'store'])
    ->name('clients.store');
    // Enregistrer les modifications d'un client
Route::put('/clients/{client}', [ClientController::class, 'update'])
    ->whereNumber('client')
    ->name('clients.update');

// Détails d'un client
Route::get('/clients/{client}', [ClientController::class, 'show'])
    ->whereNumber('client')
    ->name('clients.show');

// Modification d'un client
Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])
    ->whereNumber('client')
    ->name('clients.edit');
    // Archiver un client
Route::delete('/clients/{client}', [ClientController::class, 'destroy'])
    ->name('clients.destroy');

// Restaurer un client archivé
Route::patch('/clients/{id}/restore', [ClientController::class, 'restore'])
    ->name('clients.restore');
