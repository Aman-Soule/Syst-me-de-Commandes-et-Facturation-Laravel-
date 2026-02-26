<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [BurgerController::class, 'accueil'])->name('welcome');
Route::get('/clients', [BurgerController::class, 'catalogue'])->name('clients.catalogue');

// Dashboard admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

Route::prefix('admin')->group(function () {
    Route::get('/burgers', [BurgerController::class, 'index'])->name('burgers.index');
    Route::get('/burgers/create', [BurgerController::class, 'create'])->name('burgers.create');
    Route::post('/burgers', [BurgerController::class, 'store'])->name('burgers.store');
    Route::get('/burgers/{burger}/edit', [BurgerController::class, 'edit'])->name('burgers.edit');
    Route::put('/burgers/{burger}', [BurgerController::class, 'update'])->name('burgers.update');
    Route::delete('/burgers/{burger}', [BurgerController::class, 'destroy'])->name('burgers.destroy');
});

Route::get('/admin/commandes', [AdminController::class, 'commandes'])->name('commandes.liste');
Route::get('/admin/commandes/{commande}/edit', [AdminController::class, 'edit'])->name('commandes.edit');
Route::put('/admin/commandes/{commande}', [AdminController::class, 'update'])->name('commandes.update');
Route::delete('/admin/commandes/{commande}', [AdminController::class, 'destroy'])->name('commandes.destroy');

//Paiement
Route::get('/admin/paiements', [PaiementController::class, 'index'])->name('paiements.liste');

Route::get('commandes/{commande}/facture', [CommandeController::class, 'telechargerFacture'])
    ->name('commandes.facture');

// Routes pour les commandes côté clients
Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
Route::get('/commandes/create/{burger}', [CommandeController::class, 'create'])->name('commandes.create');
Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
//Route::get('/commandes/{commande}/edit', [CommandeController::class, 'edit'])->name('commandes.edit');
//Route::put('/commandes/{commande}', [CommandeController::class, 'update'])->name('commandes.update');
//Route::delete('/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy');
