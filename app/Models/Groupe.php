<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    // Relation avec les utilisateurs (membres du groupe)
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Relation avec les tâches partagées dans ce groupe
    public function taches()
    {
        return $this->hasMany(TacheGroupe::class);
    }
}
