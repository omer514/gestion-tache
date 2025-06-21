<?php

namespace App\Models;
use HasFactory;

use Illuminate\Database\Eloquent\Model;

class HistoriqueProductivite extends Model
{
    

    protected $fillable = [
        'user_id', 'date', 'taches_terminees', 'score_du_jour'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

