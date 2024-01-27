<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\LeagueMatch;
use App\Models\Team;
use Illuminate\Http\Request;

class GoalController extends Controller
{

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'player_id' => 'required',
            'type' => 'required',
        ]);
        $team = Team::findOrFail($request->team_id);
        $match = LeagueMatch::findOrFail($request->match_id);
        $goal = new Goal();
        $goal->match_id = $request->match_id;
        $goal->team_id = $request->team_id;
        $goal->player_id = $request->player_id;
        $goal->type = $request->type;
        $goal->field_site = $team->field_site;
        $goal->save();
        return redirect()->route('match.show', $match->slug)->with('message', $request->type . ' Add successfully');
    }
}
