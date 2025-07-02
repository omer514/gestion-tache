<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use App\Models\ScoreEvolution;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TacheController extends Controller
{
    public function index(Request $request)
    {
        $maintenant = Carbon::now();

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

        // Pagination avec tri (et conservation des filtres via withQueryString)
        $taches = $query->orderByDesc('est_urgente')
                        ->orderBy('echeance')
                        ->paginate(10)
                        ->withQueryString();

        // Attribut temporaire pour gérer les échéances dépassées
        foreach ($taches as $tache) {
            $tache->echeanceDepassee = $tache->echeance && Carbon::parse($tache->echeance)->isPast();
        }

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
            'echeance' => ['nullable', 'date', function($attribute, $value, $fail) {
                if ($value && Carbon::parse($value)->isPast()) {
                    $fail("La date et l'heure d'échéance ne peuvent pas être dans le passé.");
                }
            }],
        ]);

        $tache = new Tache();
        $tache->titre = $validated['titre'];
        $tache->description = $validated['description'] ?? null;
        $tache->priorite = $validated['priorite'];
        $tache->statut = $validated['statut'];
        $tache->echeance = $validated['echeance'] ?? null;
        $tache->est_urgente = $request->has('est_urgente');
        $tache->user_id = Auth::id();
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
            'echeance' => ['nullable', 'date', function($attribute, $value, $fail) {
                if ($value && Carbon::parse($value)->isPast()) {
                    $fail("La date et l'heure d'échéance ne peuvent pas être dans le passé.");
                }
            }],
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

    // ✅ Marquer la tâche comme terminée (si l'échéance n'est pas encore passée)
    public function marquerTerminee(Tache $tache)
    {
        if ($tache->user_id !== Auth::id()) {
            abort(403);
        }

        if ($tache->echeance && Carbon::parse($tache->echeance)->isPast()) {
            return redirect()->route('taches.index')->with('error', 'Échéance dépassée. Impossible de marquer cette tâche manuellement.');
        }

        $tache->statut = 'terminee';
        $tache->save();

        $user = Auth::user();
        $points = 10;

        ScoreEvolution::create([
            'user_id' => $user->id,
            'score' => $points,
            'action' => 'Tâche terminée : ' . $tache->titre,
        ]);

        $user->total_score += $points;
        $this->verifierEtAttribuerBadges($user);

        if ($user->total_score >= 1000) {
            $user->niveau = 'Expert';
        } elseif ($user->total_score >= 500) {
            $user->niveau = 'Avancé';
        } elseif ($user->total_score >= 100) {
            $user->niveau = 'Intermédiaire';
        } else {
            $user->niveau = 'Débutant';
        }

        $user->save();

        return redirect()->route('taches.index')->with('success', 'Tâche terminée. Score +10');
    }

    protected function verifierEtAttribuerBadges($user)
    {
        $badges = [
            'Débutant' => 100,
            'Pro' => 500,
            'Expert' => 1000,
        ];

        foreach ($badges as $nom => $scoreMin) {
            if ($user->total_score >= $scoreMin) {
                $badge = Badge::firstOrCreate(['nom' => $nom], [
                    'description' => "Badge pour un score >= $scoreMin",
                    'icone' => 'fa-star'
                ]);
                if (!$user->badges->contains($badge->id)) {
                    $user->badges()->attach($badge->id, ['attribue_le' => now()]);
                }
            }
        }
    }

    // ✅ Mettre à jour automatiquement les tâches échues (sans points)
   public function majStatut()
{
    // Récupère les tâches non terminées de l'utilisateur avec une échéance dépassée (date + heure)
    $taches = Tache::where('user_id', Auth::id())
        ->whereIn('statut', ['en_attente', 'en_cours'])
        ->whereNotNull('echeance')
        ->where('echeance', '<', Carbon::now()) // tient compte de la date ET de l'heure
        ->get();

    foreach ($taches as $tache) {
        $tache->statut = 'en_retard'; // ou autre statut selon ta logique
        $tache->save();
    }

    return redirect()->route('taches.index')->with('success', 'Tâches échues mises à jour avec succès.');
}
}
