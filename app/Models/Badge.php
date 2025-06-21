<?php

namespace App\Models;
use HasFactory;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    

    protected $fillable = [
        'nom', 'description', 'icone'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'user_badges');
    }
}

