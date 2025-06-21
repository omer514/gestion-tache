<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rappel extends Model
{
   

    protected $fillable = [
        'tache_id', 'message', 'heure_rappel'
    ];

    public function tache() {
        return $this->belongsTo(Tache::class);
    }
}
