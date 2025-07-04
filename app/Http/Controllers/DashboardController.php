<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tache; // Ton modèle de tâche

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Tâches en cours : statut = 'en_cours'
    $tachesEnCours = Tache::where('user_id', $user->id)
                          ->where('statut', 'en_cours')
                          ->count();

    // Tâches terminées : statut = 'terminee'
    $tachesTerminees = Tache::where('user_id', $user->id)
                           ->where('statut', 'terminee')
                           ->count();

    // Tâches urgentes : est_urgente = 1
    $tachesUrgentes = Tache::where('user_id', $user->id)
                          ->where('est_urgente', 1)
                          ->count();

    return view('dashboard', compact('tachesEnCours', 'tachesTerminees', 'tachesUrgentes'));
}

}
