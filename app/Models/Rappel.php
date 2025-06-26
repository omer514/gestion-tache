<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rappel extends Model
{
    use HasFactory;

    protected $fillable = [
        'tache_groupe_id', 'user_id', 'rappel_at',
    ];

    protected $dates = ['rappel_at'];

    // Le rappel appartient à une tâche de groupe
    public function tache()
    {
        return $this->belongsTo(TacheGroupe::class, 'tache_groupe_id');
    }

    // Le rappel est destiné à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
