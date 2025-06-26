<?php

namespace App\Http\Controllers;

use App\Models\Rappel;
use App\Models\TacheGroupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RappelController extends Controller
{
    // Formulaire pour créer un rappel personnalisé pour une tâche donnée
    public function create($tache_id)
    {
        $tache = TacheGroupe::findOrFail($tache_id);

        return view('rappels.create', compact('tache'));
    }

    // Stocke un rappel personnalisé pour une tâche et un utilisateur donné
    public function store(Request $request, $tache_id)
    {
        $request->validate([
            'rappel_at' => 'required|date|after:now',
        ]);

        $rappel = Rappel::create([
            'tache_groupe_id' => $tache_id,
            'user_id' => Auth::id(),
            'rappel_at' => $request->rappel_at,
        ]);

        return redirect()->route('tachegroupes.show', $tache_id)
            ->with('success', 'Rappel personnalisé créé avec succès.');
    }
}
