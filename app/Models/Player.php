<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    public function goal()
    {
        return $this->hasMany(Goal::class, 'player_id', 'id')->where('type', 'Goal');
    }
    public function foul()
    {
        return $this->hasMany(Goal::class, 'player_id', 'id')->where('type', 'Foul');
    }

    public function team()
    {
        return $this->belongsToMany(Team::class,'team_players');
    }
}
