<?php

use App\Http\Controllers\ProfileController;
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
