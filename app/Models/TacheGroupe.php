<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TacheGroupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'contenu', 'date_limite', 'groupe_id', 'user_id',
    ];

    // La tâche appartient à un groupe
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    // La tâche a un auteur (utilisateur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une tâche peut avoir plusieurs rappels
    public function rappels()
    {
        return $this->hasMany(Rappel::class);
    }

    public function storePartage(Request $request)
{
    $request->validate([
        'groupe_id' => 'required|exists:groupes,id',
        'titre' => 'required|string|max:255',
    ]);

    TacheGroupe::create([
        'groupe_id' => $request->groupe_id,
        'titre' => $request->titre,
        'cree_par' => auth()->id(),
    ]);

    return redirect()->route('taches.index')->with('success', 'Tâche partagée avec succès !');
}

}
