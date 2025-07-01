<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TacheController;
use Illuminate\Support\Facades\Route;

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

// 🗂 Liste de toutes les tâches (index)
    Route::get('/taches', [TacheController::class, 'index'])->name('taches.index');

    // ➕ Formulaire de création d'une nouvelle tâche
    Route::get('/taches/create', [TacheController::class, 'create'])->name('taches.create');

    // ✅ Enregistrer une nouvelle tâche (POST)
    Route::post('/taches', [TacheController::class, 'store'])->name('taches.store');

    // 📝 Formulaire de modification d'une tâche existante
    Route::get('/taches/{tache}/edit', [TacheController::class, 'edit'])->name('taches.edit');

    // 💾 Mettre à jour une tâche (PUT)
    Route::put('/taches/{tache}', [TacheController::class, 'update'])->name('taches.update');

    // ❌ Supprimer une tâche
    Route::delete('/taches/{tache}', [TacheController::class, 'destroy'])->name('taches.destroy');

    // ✅ Marquer une tâche comme terminée (PATCH personnalisé)
    Route::patch('/taches/{tache}/terminer', [TacheController::class, 'terminer'])->name('taches.terminer');



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
