<?php

namespace App\Models;
use HasFactory;


use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{

    protected $fillable = [
        'user_id', 'badge_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function badge() {
        return $this->belongsTo(Badge::class);
    }
}

