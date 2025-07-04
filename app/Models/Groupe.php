<?php

// app/Models/Groupe.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'createur_id'];

    public function createur()
    {
        return $this->belongsTo(User::class, 'createur_id');
    }

    

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }


public function membres()
{
    return $this->belongsToMany(User::class, 'groupe_user', 'groupe_id', 'user_id');
}


}
