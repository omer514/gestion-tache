<?php

namespace App\Http\Controllers;

use App\Models\HistoriqueProductivite;
use App\Models\User;
use Illuminate\Http\Request;

class HistoriqueProductiviteController extends Controller
{
    /**
     * Affiche la liste des historiques.
     */
    public function index()
    {
        $historiques = HistoriqueProductivite::with('user')->latest()->get();
        return view('historique-productivites.index', compact('historiques'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $users = User::all();
        return view('historique-productivites.create', compact('users'));
    }

    /**
     * Enregistre un historique.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'taches_terminees' => 'required|integer|min:0',
            'score_du_jour' => 'required|numeric|min:0',
        ]);

        HistoriqueProductivite::create($validated);

        return redirect()->route('historique-productivites.index')
                         ->with('success', 'Historique ajouté avec succès.');
    }

    /**
     * Affiche un historique en détail.
     */
    public function show(HistoriqueProductivite $historique_productivite)
    {
        return view('historique-productivites.show', ['historique' => $historique_productivite]);
    }

    /**
     * Formulaire de modification.
     */
    public function edit(HistoriqueProductivite $historique_productivite)
    {
        $users = User::all();
        return view('historique-productivites.edit', [
            'historique' => $historique_productivite,
            'users' => $users
        ]);
    }

    /**
     * Mise à jour d'un historique.
     */
    public function update(Request $request, HistoriqueProductivite $historique_productivite)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'taches_terminees' => 'required|integer|min:0',
            'score_du_jour' => 'required|numeric|min:0',
        ]);

        $historique_productivite->update($validated);

        return redirect()->route('historique-productivites.index')
                         ->with('success', 'Historique mis à jour avec succès.');
    }

    /**
     * Supprime un historique.
     */
    public function destroy(HistoriqueProductivite $historique_productivite)
    {
        $historique_productivite->delete();

        return redirect()->route('historique-productivites.index')
                         ->with('success', 'Historique supprimé avec succès.');
    }
}
