<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'priorite',
        'statut',
        'echeance',
        'est_urgente'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rappels()
    {
        return $this->hasMany(Rappel::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function membres()
    {
        return $this->belongsToMany(User::class, 'tache_groupes');
    }

    





}
