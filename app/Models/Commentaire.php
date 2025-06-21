<?php

namespace App\Models;
use HasFactory;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    

    protected $fillable = [
        'tache_id', 'user_id', 'contenu'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tache() {
        return $this->belongsTo(Tache::class);
    }
}
