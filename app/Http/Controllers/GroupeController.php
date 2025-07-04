<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GroupeController extends Controller
{
    // Affiche la liste des groupes de l'utilisateur connecté
    public function index()
    {
        $groupes = Auth::user()->groupes()->wherePivot('accepte', true)->get();
        return view('groupes.index', compact('groupes'));
    }

    // Affiche les détails et les membres d'un groupe
   public function show(Groupe $groupe)
{
    $user = Auth::user();

    // Vérifie que l'utilisateur fait bien partie du groupe (avec pivot accepte = true)
    if (!$groupe->membres()->where('user_id', $user->id)->wherePivot('accepte', true)->exists()) {
        abort(403);
    }

    // Récupère les membres acceptés
    $membres = $groupe->membres()->wherePivot('accepte', true)->get();

    return view('groupes.show', compact('groupe'));
}

    // Affiche le formulaire de création d'un groupe
    public function create()
    {
        return view('groupes.create');
    }

    // Enregistre un nouveau groupe
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $groupe = Groupe::create([
            'nom' => $request->nom,
            'createur_id' => Auth::id(),
        ]);

        // Le créateur devient automatiquement membre
        $groupe->membres()->attach(Auth::id(), ['accepte' => true]);

        return redirect()->route('groupes.index')->with('success', 'Groupe créé avec succès.');
    }

    // Affiche le formulaire pour inviter un membre dans le groupe
    public function showInvitationForm(Groupe $groupe)
    {
        if (!$groupe->membres->contains(Auth::id())) {
            abort(403);
        }

        return view('groupes.inviter', compact('groupe'));
    }


    

    // Envoie une invitation par email
    public function envoyerInvitation(Request $request, Groupe $groupe)
    {
        if (!$groupe->membres->contains(Auth::id())) {
            abort(403);
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $invite = User::where('email', $request->email)->first();

        // Vérifie si déjà membre
        if ($groupe->membres->contains($invite->id)) {
            return back()->with('error', 'Cet utilisateur est déjà membre.');
        }

        // Vérifie s'il a déjà une invitation en attente
        $invitationExistante = Invitation::where([
            ['groupe_id', '=', $groupe->id],
            ['utilisateur_id', '=', $invite->id],
            ['statut', '=', 'en_attente']
        ])->exists();

        if ($invitationExistante) {
            return back()->with('error', 'Invitation déjà envoyée.');
        }

        // Crée l'invitation
        Invitation::create([
            'groupe_id' => $groupe->id,
            'utilisateur_id' => $invite->id,
            'statut' => 'en_attente',
        ]);

        // Envoi réel de l'e-mail
        Mail::send('emails.invitation', ['groupe' => $groupe, 'user' => $invite], function ($message) use ($invite, $groupe) {
            $message->to($invite->email)
                    ->subject("Invitation à rejoindre le groupe: {$groupe->nom}");
        });

        return back()->with('success', 'Invitation envoyée avec succès.');
    }

    // Accepte une invitation
    public function accepterInvitation(Invitation $invitation)
    {
        if ($invitation->utilisateur_id !== Auth::id()) {
            abort(403);
        }

        $invitation->update(['statut' => 'acceptee']);

        $invitation->groupe->membres()->attach(Auth::id(), ['accepte' => true]);

        return redirect()->route('groupes.index')->with('success', 'Vous avez rejoint le groupe.');
    }
}
