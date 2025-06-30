<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TacheController extends Controller
{
    public function index(Request $request)
    {
        $query = Tache::where('user_id', Auth::id());

        // Filtres facultatifs
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        if ($request->filled('echeance')) {
            $query->whereDate('echeance', $request->echeance);
        }

        // Trier les tâches les plus urgentes d'abord
        $taches = $query->orderByDesc('est_urgente')
                        ->orderBy('echeance')
                        ->paginate(10);

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

        $tache = new Tache();
        $tache->titre = $validated['titre'];
        $tache->description = $validated['description'] ?? null;
        $tache->priorite = $validated['priorite'];
        $tache->statut = $validated['statut'];
        $tache->echeance = $validated['echeance'] ?? null;
        $tache->est_urgente = $request->has('est_urgente');
        $tache->user_id = Auth::id(); // 👈 obligatoire ici
        $tache->save();

        return redirect()->route('taches.index')->with('success', 'Tâche créée avec succès.');
    }

    public function edit(Tache $tache)
    {
        if ($tache->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        return view('taches.edit', compact('tache'));
    }

    public function update(Request $request, Tache $tache)
    {
        if ($tache->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|in:faible,moyenne,haute',
            'statut' => 'required|in:en_attente,en_cours,terminee',
            'echeance' => 'nullable|date',
        ]);

        $tache->update([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'priorite' => $validated['priorite'],
            'statut' => $validated['statut'],
            'echeance' => $validated['echeance'] ?? null,
            'est_urgente' => $request->has('est_urgente'),
        ]);

        return redirect()->route('taches.index')->with('success', 'Tâche modifiée avec succès.');
    }

    public function destroy(Tache $tache)
    {
        if ($tache->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $tache->delete();

        return redirect()->route('taches.index')->with('success', 'Tâche supprimée avec succès.');
    }

    // ✅ Marquer la tâche comme terminée
    public function marquerTerminee(Tache $tache)
    {
        if ($tache->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $tache->statut = 'terminee';
        $tache->save();

        return redirect()->route('taches.index')->with('success', 'Tâche marquée comme terminée.');
    }
}
