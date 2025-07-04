<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['groupe_id', 'user_id', 'statut'];

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
