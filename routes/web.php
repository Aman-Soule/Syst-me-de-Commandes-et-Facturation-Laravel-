<?php

use App\Http\Controllers\BurgerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [BurgerController::class, 'accueil'])->name('welcome');
Route::get('/clients', [BurgerController::class, 'catalogue'])->name('clients.catalogue');


Route::prefix('admin')->group(function () {
    Route::get('/burgers', [BurgerController::class, 'index'])->name('burgers.index');
    Route::get('/burgers/create', [BurgerController::class, 'create'])->name('burgers.create');
    Route::post('/burgers', [BurgerController::class, 'store'])->name('burgers.store');
    Route::get('/burgers/{burger}/edit', [BurgerController::class, 'edit'])->name('burgers.edit');
    Route::put('/burgers/{burger}', [BurgerController::class, 'update'])->name('burgers.update');
    Route::delete('/burgers/{burger}', [BurgerController::class, 'destroy'])->name('burgers.destroy');
});
