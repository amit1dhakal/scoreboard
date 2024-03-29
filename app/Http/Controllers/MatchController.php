<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Goal;
use App\Models\LeagueMatch;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matches = LeagueMatch::with(['hometeam:id,name', 'awayteam:id,name'])->latest()->get();
        return view('admin.match.index', compact("matches"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (empty(Helper::league())) {
            return redirect()->route('match.index')->withErrors('League is not created');
        }
        if (@Helper::league()->status != 0) {
            return redirect()->route('match.index')->withErrors('League is already Running');
        }

        $teams = Team::latest()->get();

        if (count($teams) < 2) {
            return redirect()->route('team.index')->withErrors('At least 2 teams are required');
        }
        $users = User::where('role', 'Referee')->latest()->get(['id', 'name', 'email']);
        if (empty($users)) {
            return redirect()->back()->withErrors('Referee is not added');
        }
        return view('admin.match.create', compact("teams", "users"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'home_team_id' => 'required',
            'away_team_id' => 'required',
            'user_id' => 'required',
            'name' => 'required',
            'date' => 'required|date',
        ]);
        $league = Helper::league();
        if (($request->date < $league->start_date) && ($request->date > $league->end_date)) {
            return redirect()->back()->withInput()->withErrors('Date must be in league duration');
        }
        if ($request->home_team_id == $request->away_team_id) {
            return redirect()->back()->withInput()->withErrors('Home Team and Away Team must not be same');
        }
        if (LeagueMatch::where('home_team_id', $request->home_team_id)->where('away_team_id', $request->away_team_id)->exists()) {
            return redirect()->back()->withInput()->withErrors('This team combination match already exit');
        }
        if (LeagueMatch::where('date', $request->date)->where('user_id', $request->user_id)->exists()) {
            return redirect()->back()->withInput()->withErrors('Referee is in another match at ' . $request->date);
        }


        //   return [$request->team1_id, $request->team2_id];
        $match = new LeagueMatch();
        $match->name = $request->name;
        $match->home_team_id = $request->home_team_id;
        $match->away_team_id = $request->away_team_id;
        $match->user_id = $request->user_id;
        $match->date = $request->date;
        $match->slug = Str::slug($request->name).'-'.Helper::randomText();
        $match->save();
        return redirect()->route('match.index')->with('message', 'Match created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $match = LeagueMatch::with(['hometeam', 'referee', 'awayteam', 'winnerteam', 'goal', 'foul'])->where('slug', $slug)->firstOrFail();
        return view('admin.match.show', compact("match"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $match = LeagueMatch::where('status', 0)->where('slug', $slug)->firstOrFail();
        if (Helper::league()->status != 0) {
            return redirect()->route('league.index')->withErrors('League already started');
        } else {

            $teams = Team::latest()->get();

            if (count($teams) < 2) {
                return redirect()->route('team.index')->withErrors('At least 2 teams are required');
            }
            $users = User::where('role', 'Referee')->latest()->get(['id', 'name', 'email']);
            if (empty($users)) {
                return redirect()->back()->withErrors('Referee is not added');
            }
            return view('admin.match.edit', compact("teams", "match", "users"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'home_team_id' => 'required',
            'away_team_id' => 'required',
            'user_id' => 'required',
            'name' => 'required',
            'date' => 'required',
        ]);
        $match =  LeagueMatch::where('status', 0)->where('slug', $slug)->firstOrFail();

        $league = Helper::league();
        if (($request->date < $league->start_date) && ($request->date > $league->end_date)) {
            return redirect()->back()->withInput()->withErrors('Date must be in league duration');
        }

        if ($request->home_team_id == $request->away_team_id) {
            return redirect()->back()->withInput()->withErrors('Home Team and Away Team must not be same');
        }
        if (LeagueMatch::where('id', '!=', $match->id)->where('home_team_id', $request->home_team_id)->where('away_team_id', $request->away_team_id)->exists()) {
            return redirect()->back()->withInput()->withErrors('This team combination match already exit');
        }
        if (LeagueMatch::where('id', '!=', $match->id)->where('date', $request->date)->where('user_id', $request->user_id)->exists()) {
            return redirect()->back()->withInput()->withErrors('Referee is in another match at ' . $request->date);
        }

        //   return [$request->team1_id, $request->team2_id];

        $match->name = $request->name;
        $match->home_team_id = $request->home_team_id;
        $match->away_team_id = $request->away_team_id;
        $match->user_id = $request->user_id;
        $match->date = $request->date;
        $match->update();
        return redirect()->route('match.index')->with('message', 'Match updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $match =  LeagueMatch::where('slug', $slug)->firstOrFail();
        Goal::where('match_id', $match->id)->delete();
        $match->delete();
        return redirect()->route('match.index')->with('message', 'Match deleted successfully');
    }

    public function statuschange(Request $request, $slug)
    {
        // return $request;
        $match = LeagueMatch::with('goal')->where('slug', $slug)->firstOrFail();
        if ($match->status == 0) {

            $match->status = 1;
        } elseif ($match->status == 1) {
            $match->status = 2;
        } elseif ($match->status == 2) {

            $match->status = 3;
        } else {

            if ($match->home_team_id == $request->winner_team_id) {
                $match->winner_team_id = $match->home_team_id;
                $match->loser_team_id =  $match->away_team_id;
            } else {
                $match->winner_team_id = $match->away_team_id;
                $match->loser_team_id =  $match->home_team_id;
            }

            $match->status = 4;
        }
        $match->update();
        Helper::scoreboardupdate($match);
        return redirect()->route('match.show', $match->slug)->with('message', 'Match status updated successfully');
    }
}
