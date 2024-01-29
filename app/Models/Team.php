<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function player()
    {
        return $this->belongsToMany(Player::class,'team_players');
    }
    
    public function goal(){
        return $this->hasMany(Goal::class,'team_id','id');
    }

    public function winmatch()
    {
        return $this->hasMany(LeagueMatch::class, 'winner_team_id', 'id');
    }
    public function losematch()
    {
        return $this->hasMany(LeagueMatch::class, 'loser_team_id', 'id');
    }
}
