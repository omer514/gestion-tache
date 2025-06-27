<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TacheController extends Controller
{
    // public function __construct()
    // {
    //     // Empêche tout accès si l'utilisateur n'est pas connecté
    //     $this->middleware('auth');
    // }

    public function index()
{
    $taches = Tache::where('user_id', auth::id())->paginate(10);
    return view('taches.index', compact('taches'));
}
    public function create()
    {
        return view('taches.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priorite' => 'required|in:faible,moyenne,haute',
        'statut' => 'required|in:en_attente,en_cours,terminee',
        'echeance' => 'nullable|date',
    ]);

    // Création manuelle de la tâche avec l'utilisateur connecté
    $tache = new Tache();
    $tache->titre = $validated['titre'];
    $tache->description = $validated['description'] ?? null;
    $tache->priorite = $validated['priorite'];
    $tache->statut = $validated['statut'];
    $tache->echeance = $validated['echeance'] ?? null;
    $tache->est_urgente = $request->has('est_urgente');
    $tache->user_id = auth::id(); // 👈 lier à l'utilisateur connecté
    $tache->save();

    return redirect()->route('taches.index')->with('success', 'Tâche créée avec succès.');
}


    public function edit(Tache $tache)
    {
        if ($tache->user_id !== auth::id()) {
            abort(403, 'Non autorisé');
        }

        return view('taches.edit', compact('tache'));
    }

    public function update(Request $request, Tache $tache)
    {

       
        if ($tache->user_id !== auth::id()) {
            abort(403, 'Non autorisé');
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'priorite' => 'required|in:faible,moyenne,haute',
            'statut' => 'required|in:en_attente,en_cours,terminee',
            'echeance' => 'nullable|date',
        ]);

        $tache->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'priorite' => $request->priorite,
            'statut' => $request->statut,
            'echeance' => $request->echeance,
            'est_urgente' => $request->has('est_urgente'),
        ]);

        return redirect()->route('taches.index')->with('success', 'Tâche modifiée avec succès.');
    }

    public function destroy(Tache $tache)
    {

        if ($tache->user_id !== auth::id()) {
            abort(403, 'Non autorisé');
        }

        $tache->delete();

        return redirect()->route('taches.index')->with('success', 'Tâche supprimée avec succès.');
    }

}
