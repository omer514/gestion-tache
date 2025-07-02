<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TacheController;
use App\http\Controllers\ProductiviteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoriqueProductiviteController;


Route::get('/', function () {
    return view('auth.login');
});



Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// Liste des tâches
Route::get('/taches', [TacheController::class, 'index'])->name('taches.index');

// Formulaire de création
Route::get('/taches/create', [TacheController::class, 'create'])->name('taches.create');

// Enregistrement d'une nouvelle tâche
Route::post('/taches', [TacheController::class, 'store'])->name('taches.store');

// Formulaire d'édition d'une tâche existante
Route::get('/taches/{tache}/edit', [TacheController::class, 'edit'])->name('taches.edit');

// Mise à jour d'une tâche existante
Route::put('/taches/{tache}', [TacheController::class, 'update'])->name('taches.update');

// Suppression d'une tâche
Route::delete('/taches/{tache}', [TacheController::class, 'destroy'])->name('taches.destroy');
// marquer les tâches terminer 
// Route::patch('/taches/{tache}/terminer', [TacheController::class, 'marquerTerminee'])->name('taches.terminer');


// Route::patch('/taches/maj-statut', [TacheController::class, 'majStatut'])->name('taches.majStatut');


Route::get('/productivite/historique', [ProductiviteController::class, 'historique'])->name('productivite.historique');

Route::get('/dashboard/productivite', [ProductiviteController::class, 'dashboard'])->name('productivite.dashboard');


Route::post('/taches/{tache}/terminer', [TacheController::class, 'marquerTerminee'])->name('taches.terminer');
Route::post('/taches/maj-statut', [TacheController::class, 'majStatut'])->name('taches.majStatut');





    //Route historiques_productivites(avec touts les mehodes)

    Route::middleware(['auth'])->group(function () {
    Route::resource('historique-productivites', HistoriqueProductiviteController::class);
});


    // Formulaire de changement de mot de passe
Route::get('/password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'edit'])
    ->middleware('auth')
    ->name('password.change');

// Soumission du formulaire
Route::post('/password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'update'])
    ->middleware('auth')
    ->name('password.change.update');

});

require __DIR__.'/auth.php';
