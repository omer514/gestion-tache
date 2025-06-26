<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TacheGroupeController;
use App\Http\Controllers\RappelController;
use App\Http\Controllers\GroupeController;

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
    Route::resource('tachegroupes', TacheGroupeController::class);
    Route::resource('tachegroupes', TacheGroupeController::class);
    Route::resource('groupes', GroupeController::class);

// Pour les rappels liés à une tâche
Route::get('tachegroupes/{tache}/rappels/create', [RappelController::class, 'create'])->name('rappels.create');
Route::post('tachegroupes/{tache}/rappels', [RappelController::class, 'store'])->name('rappels.store');
Route::get('/taches/partager', [TacheGroupeController::class, 'partager'])->name('taches.partager');





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
