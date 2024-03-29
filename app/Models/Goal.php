<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }
    public function match()
    {
        return $this->belongsTo(LeagueMatch::class, 'match_id', 'id');
    }
}
