<?php

namespace App\Models;
use HasFactory;

use Illuminate\Database\Eloquent\Model;

class HabitudeUtilisateur extends Model
{
    

    protected $fillable = [
        'user_id', 'jour', 'heure_debut', 'heure_fin'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

