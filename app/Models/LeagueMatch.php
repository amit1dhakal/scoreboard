<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeagueMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';
    protected $casts = [
        'team_ids' => 'array',
    ];

    public function teams($id)
    {
        return Team::whereIn('id', $id)->get();
    }
    public function winnterteam()
    {
        return $this->belongsTo(Team::class, 'winner_team_id', 'id');
    }
    public function loserteam()
    {
        return $this->belongsTo(Team::class, 'loser_team_id', 'id');
    }
    public function goal($match = 0)
    {
        if ($match == 0) {
            return $this->hasMany(Goal::class, 'match_id', 'id')->where('type', 'Goal');
        } else {
            return $this->hasMany(Goal::class, 'match_id', 'id')->where('match_id', $match)->where('type', 'Goal');
        }
    }
    public function foul($match = 0)
    {
        if ($match == 0) {
            return $this->hasMany(Goal::class, 'match_id', 'id')->where('type', 'Foul');
        } else {
            return $this->hasMany(Goal::class, 'match_id', 'id')->where('match_id', $match)->where('type', 'Foul');
        }
    }
}
