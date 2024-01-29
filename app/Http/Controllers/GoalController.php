<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Goal;
use App\Models\LeagueMatch;
use Illuminate\Http\Request;

class GoalController extends Controller
{

    public function store(Request $request)
    {
        //  return $request;
        $request->validate([
            'player_id' => 'required',
            'type' => 'required',
        ]);
        // $team = Team::findOrFail($request->team_id);
        $match = LeagueMatch::with('hometeam', 'awayteam')->findOrFail($request->match_id);
        $goal = new Goal();
        $goal->match_id = $request->match_id;
        $goal->team_id = $request->team_id;
        $goal->player_id = $request->player_id;
        $goal->type = $request->type;
        $goal->match_duration = $match->status == 1 ? 'First Half' : 'Second Half';
        $goal->field_site = $match->home_team_id == $request->team_id ? 'Home' : 'Away';
        $goal->event_time = $match->time;
        $goal->save();
        Helper::scoreboardupdate($match);
        return redirect()->route('match.show', $match->slug)->with('message', $request->type . ' Add successfully');
    }
    public function update(Request $request)
    {
        //  return $request;
        $request->validate([
            'player_id' => 'required',
            'type' => 'required',
            'goal_id' => 'required',
        ]);
        $goal = Goal::with('match')->findOrFail($request->goal_id);


        $goal->player_id = $request->player_id;
        $goal->type = $request->type;
        $goal->update();
        Helper::scoreboardupdate($goal->match);
        return redirect()->route('match.show', $goal->match->slug)->with('message', $request->type . ' Update successfully');
    }
}
