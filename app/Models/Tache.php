<?php

namespace App\Models;
 use HasFactory;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
   

    protected $fillable = [
        'user_id', 'titre', 'description', 'priorite',
        'statut', 'echeance', 'est_urgente'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rappels() {
        return $this->hasMany(Rappel::class);
    }

    public function commentaires() {
        return $this->hasMany(Commentaire::class);
    }

    public function membres() {
        return $this->belongsToMany(User::class, 'tache_groupes');
    }
}

