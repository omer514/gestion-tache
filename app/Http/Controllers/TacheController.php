<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use App\Models\ScoreEvolution;
use App\Models\Badge;
use App\Models\Groupe;
use App\Models\User;
use App\Models\GroupeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'tache_id' => $tache->id,
            'score' => $points,
            'action' => 'Tâche terminée : ' . $tache->titre,
            'recorded_at' => now(),
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


 public function annulerTerminaison(Tache $tache)
{
    // Vérifie que l'utilisateur est bien le propriétaire
    if ($tache->user_id !== Auth::id()) {
        return back()->with('error', "Vous n'êtes pas autorisé à modifier cette tâche.");
    }

    // Si la tâche est bien terminée, on peut l'annuler
    if ($tache->statut === 'terminee') {

        // Revenir à en cours
        $tache->statut = 'en_cours';
        $tache->save();

        // Récupérer l'utilisateur
        $user = Auth::user();

        // Récupérer le score associé à cette tâche
        $score = ScoreEvolution::where('user_id', $user->id)
            ->where('tache_id', $tache->id)
            ->value('score'); // récupère juste la valeur

        // Supprimer la ligne dans score_evolutions
        ScoreEvolution::where('user_id', $user->id)
            ->where('tache_id', $tache->id)
            ->delete();

        // Mettre à jour le score total de l'utilisateur
        if ($score) {
           $user->total_score = max(0, $user->total_score - $score); // éviter score négatif
            $user->save();
            Auth::setUser($user); // actualiser l'utilisateur en session

            // Recalculer niveau ou badges si tu as une méthode
            if (method_exists($this, 'mettreAJourNiveau')) {
                $this->mettreAJourNiveau($user);
            }
        }

        return back()->with('success', 'La tâche a été remise en cours et la productivité ajustée.');
    }

    return back()->with('info', 'La tâche n\'était pas terminée.');
}
protected function mettreAJourNiveau($user)
{
    $score = $user->score;
    $niveau = 'Débutant';

    if ($score >= 200) {
        $niveau = 'Expert';
    } elseif ($score >= 100) {
        $niveau = 'Intermédiaire';
    }

    $user->niveau = $niveau;
    $user->save();
}

protected function mettreAJourBadges(User $user)
{
    $score = $user->score;

    // Supprimer tous les badges actuels
    $user->badges()->detach();

    // Réattribution des badges selon le score (à adapter à ta logique)
    if ($score >= 300) {
        $user->badges()->attach([1, 2, 3]); // Or, Argent, Bronze
    } elseif ($score >= 200) {
        $user->badges()->attach([2, 3]); // Argent, Bronze
    } elseif ($score >= 100) {
        $user->badges()->attach([3]); // Bronze
    }
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

public function show(Groupe $groupe)
{
    // Vérifie si l'utilisateur est membre du groupe
    if (! $groupe->membres->contains(Auth::id()) && $groupe->createur_id !== Auth::id()) {
        abort(403, 'Vous ne faites pas partie de ce groupe.');
    }

    // Charger les relations pour optimisation
    $groupe->load([
        'createur',
        'membres',
        'taches.assignee'
    ]);

    return view('groupes.show', compact('groupe'));
}

public function indexGroupe(Groupe $groupe)
{
    $taches = $groupe->taches()->with('assignee')->get();  // récupérer tâches du groupe
    return view('taches.indexGroupe', compact('groupe', 'taches'));
}

public function createGroupe(Groupe $groupe)
{
    // Vérifie que l'utilisateur appartient au groupe
    if (!$groupe->membres->contains(Auth::id())) {
        abort(403, 'Vous ne faites pas partie de ce groupe.');
    }

    // On récupère les membres pour l'assignation
    $membres = $groupe->membres;

    return view('taches.create_groupe', compact('groupe', 'membres'));
}

public function storeGroupe(Request $request, Groupe $groupe)
{
    // Vérifie que l'utilisateur appartient au groupe
    if (!$groupe->membres->contains(Auth::id())) {
        abort(403, 'Vous ne faites pas partie de ce groupe.');
    }

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'echeance' => ['required', 'date', function($attribute, $value, $fail) {
            if (Carbon::parse($value)->isPast()) {
                $fail("L'échéance ne peut pas être dans le passé.");
            }
        }],
        'priorite' => 'required|in:basse,moyenne,haute',
        'assignee_id' => 'nullable|exists:users,id',
    ]);

    $tache = new Tache();
    $tache->titre = $validated['nom'];
    $tache->echeance = $validated['echeance'];
    $tache->priorite = $validated['priorite'];
    $tache->statut = 'en_attente';
    $tache->user_id = Auth::id(); // Créateur de la tâche
    $tache->groupe_id = $groupe->id;
    $tache->assignee_id = $request->assignee_id ?? null;
    $tache->save();

    return redirect()->route('groupes.show', $groupe)->with('success', 'Tâche de groupe créée avec succès.');
}
}
