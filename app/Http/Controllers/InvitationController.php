<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Groupe;
use App\Models\Invitation;
use Illuminate\Support\Str;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function envoyer(Request $request, $groupeId)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $groupe = Groupe::findOrFail($groupeId);
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        $token = Str::random(40);

        $invitation = Invitation::create([
            'email' => $email,
            'groupe_id' => $groupe->id,
            'user_id' => $user?->id, // null si l'utilisateur n'existe pas
            'token' => $token,
            'statut' => 'en_attente',
        ]);

       try {
    Mail::to($email)->send(new InvitationMail($invitation));
    return back()->with('success', 'Invitation envoyée avec succès.');
} 
 catch (\Exception $e) {
    // Affiche l'erreur à l'écran
    
    return back()->with('error', 'Erreur lors de l’envoi de l’email : ' . $e->getMessage());
}

        return back()->with('success', 'Invitation envoyée avec succès.');
    }

    public function accepter($token)
    {
        $invitation = Invitation::where('token', $token)
                                ->where('statut', 'en_attente')
                                ->firstOrFail();

        $invitation->update(['statut' => 'acceptee']);

        // Lier l'utilisateur connecté au groupe
        Auth::user()->groupes()->attach($invitation->groupe_id);

        return redirect('/dashboard')->with('success', 'Invitation acceptée.');
    }
}


