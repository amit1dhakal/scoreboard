<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeagueMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';
   

    public function hometeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id', 'id');
    }
    public function awayteam()
    {
        return $this->belongsTo(Team::class, 'away_team_id', 'id');
    }
    public function winnerteam()
    {
        return $this->belongsTo(Team::class, 'winner_team_id', 'id');
    }
    public function loserteam()
    {
        return $this->belongsTo(Team::class, 'loser_team_id', 'id');
    }
    
    public function goal()
    {
        return $this->hasMany(Goal::class, 'match_id', 'id')->where('type', 'Goal');
    }
    public function foul()
    {
        return $this->hasMany(Goal::class, 'match_id', 'id')->where('type', 'Foul');
    }
    public function allgoalfoul()
    {
        return $this->hasMany(Goal::class, 'match_id', 'id')->latest();
    }
    public function referee()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
