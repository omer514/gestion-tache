<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    // Liste des invitations de l'utilisateur connecté
    public function index()
    {
        $invitations = Invitation::where('user_id', Auth::id())
            ->where('statut', 'en_attente')
            ->with('groupe') // pour afficher info groupe lié
            ->get();

        return view('invitations.index', compact('invitations'));
    }

    // Accepter une invitation (tu as déjà ça dans GroupeController, mais tu peux aussi la déplacer ici)
    public function accepter(Invitation $invitation)
    {
        if ($invitation->user_id !== Auth::id()) {
            abort(403);
        }

        $invitation->update(['statut' => 'acceptee']);
        $invitation->groupe->membres()->attach(Auth::id(), ['accepte' => true]);

        return redirect()->route('invitations.index')->with('success', 'Invitation acceptée.');
    }

    // Refuser une invitation
    public function refuser(Invitation $invitation)
    {
        if ($invitation->utilisateur_id !== Auth::id()) {
            abort(403);
        }

        $invitation->update(['statut' => 'refusee']);

        return redirect()->route('invitations.index')->with('success', 'Invitation refusée.');
    }
}
