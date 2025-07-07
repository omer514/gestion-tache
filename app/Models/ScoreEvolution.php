<?php

// app/Models/ScoreEvolution.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScoreEvolution extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','tache_id', 'score', 'action', 'recorded_at'];

    protected $dates = ['recorded_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
