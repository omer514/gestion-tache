<?php

namespace App\Models;
use App\Models\Groupe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    protected $fillable = [
        'name', 'email', 'password', 'score', 'niveau'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Relations
    public function taches() {
        return $this->hasMany(Tache::class);
    }

    public function habitudes() {
        return $this->hasMany(HabitudeUtilisateur::class);
    }
    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withTimestamps()->withPivot('attribue_le');
    }


    public function historiqueProductivite() {
        return $this->hasMany(HistoriqueProductivite::class);
    }

    public function tachesPartagees() {
        return $this->belongsToMany(Tache::class, 'tache_groupes');
    }

    public function commentaires() {
        return $this->hasMany(Commentaire::class);
    }

 public function groupes()
{
    return $this->belongsToMany(Groupe::class)->withPivot('accepte')->withTimestamps();
}

public function groupesCrees()
{
    return $this->hasMany(Groupe::class, 'createur_id');
}



// Invitations reçues
public function invitations()
{
    return $this->hasMany(Invitation::class, 'utilisateur_id');
}
// public function groupes()
// {
//     return $this->belongsToMany(Groupe::class, 'groupe_user', 'user_id', 'groupe_id');
// }




}
