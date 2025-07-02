<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'icone'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('attribue_le');
    }
}


