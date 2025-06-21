<?php

namespace App\Models;
    use HasFactory;


use Illuminate\Database\Eloquent\Model;

class TacheGroupe extends Model
{

    protected $fillable = [
        'tache_id', 'user_id'
    ];

    public function tache() {
        return $this->belongsTo(Tache::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

