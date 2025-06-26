<?php

namespace App\Http\Controllers;

use App\Models\TacheGroupe;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TacheGroupeController extends Controller
{
    // Affiche la liste des tâches du groupe auxquelles l'utilisateur appartient
    public function index()
    {
        $user = Auth::user();

        // Récupérer toutes les tâches dans les groupes où l'utilisateur est membre
        $taches = TacheGroupe::whereIn('groupe_id', $user->groupes()->pluck('groupes.id'))
            ->with(['groupe', 'user', 'rappels'])
            ->get();

        return view('tachegroupes.index', compact('taches'));
    }

    // Formulaire de création d'une tâche dans un groupe
    public function create()
    {
        $user = Auth::user();

        // Groupes auxquels l'utilisateur appartient
        $groupes = $user->groupes;

        return view('tachegroupes.create', compact('groupes'));
    }

    // Stocke une nouvelle tâche partagée dans un groupe
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'date_limite' => 'required|date|after:now',
            'groupe_id' => 'required|exists:groupes,id',
        ]);

        $tache = TacheGroupe::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'date_limite' => $request->date_limite,
            'groupe_id' => $request->groupe_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('tachegroupes.index')
            ->with('success', 'Tâche créée et partagée dans le groupe avec succès.');
    }

    // Affiche une tâche spécifique
    public function show(TacheGroupe $tachegroupe)
    {
        return view('tachegroupes.show', compact('tachegroupe'));
    }

    public function partager()
{
    $groupes = Groupe::all(); // ou ->where('user_id', auth()->id()) si besoin

    return view('taches.partager', compact('groupes'));
}

}
