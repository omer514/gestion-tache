<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TacheController;
use App\http\Controllers\ProductiviteController;
use App\http\Controllers\GroupeController;
use App\http\Controllers\InvitationController;
use App\http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});



Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/invitations/accepter/{token}', [InvitationController::class, 'accepter']);

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

Route::get('/productivite/historique', [ProductiviteController::class, 'historique'])->name('productivite.historique');

Route::get('/dashboard/productivite', [ProductiviteController::class, 'dashboard'])->name('productivite.dashboard');





Route::post('/taches/{tache}/terminer', [TacheController::class, 'marquerTerminee'])->name('taches.terminer');
Route::post('/taches/{tache}/annuler-terminaison', [TacheController::class, 'annulerTerminaison'])->name('taches.annuler');
Route::post('/taches/maj-statut', [TacheController::class, 'majStatut'])->name('taches.majStatut');


// Groupes
Route::get('/groupes', [GroupeController::class, 'index'])->name('groupes.index');
Route::get('/groupes/create', [GroupeController::class, 'create'])->name('groupes.create');
Route::post('/groupes', [GroupeController::class, 'store'])->name('groupes.store');
Route::get('/groupes/{groupe}', [GroupeController::class, 'show'])->name('groupes.show');

// Invitation
Route::get('/groupes/{groupe}/inviter', [GroupeController::class, 'showInvitationForm'])->name('groupes.inviter.form');
Route::post('/groupes/{groupe}/inviter', [GroupeController::class, 'envoyerInvitation'])->name('groupes.inviter');

// Invitations de l'utilisateur
Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
Route::post('/invitations/{invitation}/accepter', [InvitationController::class, 'accepter'])->name('invitations.accepter');
Route::post('/invitations/{invitation}/refuser', [InvitationController::class, 'refuser'])->name('invitations.refuser');

Route::get('groupes/{groupe}/taches/create', [TacheController::class, 'createGroupe'])->name('taches.createGroupe');
Route::post('groupes/{groupe}/taches', [TacheController::class, 'storeGroupe'])->name('taches.storeGroupe');
Route::get('/groupes/{groupe}/taches', [TacheController::class, 'show'])->name('groupes.tache_groupe');

Route::get('/groupes/{groupe}/taches', [TacheController::class, 'indexGroupe'])->name('taches.indexGroupe');

Route::post('/groupes/{id}/inviter', [InvitationController::class, 'envoyer']);

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
