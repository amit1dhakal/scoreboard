<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\LeagueMatch;
use App\Models\Team;
use Illuminate\Http\Request;

class MatchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matches = LeagueMatch::latest()->get();
        return view('admin.match.index', compact("matches"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (@Helper::league()->status != 0) {
            return redirect()->route('league.index')->withErrors('League is not created or already started');
        } else {

            $teams = Team::latest()->get();

            if (count($teams) < 2) {
                return redirect()->route('team.index')->withErrors('At least 2 teams are required');
            }
            return view('admin.match.create', compact("teams"));
        }
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
            'team1_id' => 'required',
            'team2_id' => 'required',
            'name' => 'required',
        ]);
        if ($request->team1_id == $request->team2_id) {
            return redirect()->back()->withInput()->withErrors('Team 1 and Team 2 must not be same');
        }
        //   return [$request->team1_id, $request->team2_id];
        $match = new LeagueMatch();
        $match->name = $request->name;
        $match->team_ids = [$request->team1_id, $request->team2_id];
        // $match->team2_id = $request->team2_id;
        $match->slug = Helper::randomText();
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
        $match = LeagueMatch::where('slug', $slug)->firstOrFail();
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
        if (@Helper::league()->status != 0) {
            return redirect()->route('league.index')->withErrors('League is not created or already started');
        } else {

            $teams = Team::latest()->get();

            if (count($teams) < 2) {
                return redirect()->route('team.index')->withErrors('At least 2 teams are required');
            }
            return view('admin.match.edit', compact("teams", "match"));
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
            'team1_id' => 'required',
            'team2_id' => 'required',
            'name' => 'required',
        ]);
        if ($request->team1_id == $request->team2_id) {
            return redirect()->back()->withInput()->withErrors('Team 1 and Team 2 must not be same');
        }
        $match =  LeagueMatch::where('status', 0)->where('slug', $slug)->firstOrFail();
        $match->name = $request->name;
        $match->team1_id = $request->team1_id;
        $match->team2_id = $request->team2_id;
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
        $match->delete();
        return redirect()->route('match.index')->with('message', 'Match deleted successfully');
    }

    public function statuschange(Request $request, $slug)
    {
        // return $request;
        $match = LeagueMatch::where('slug', $slug)->firstOrFail();
        $teams = $match->teams($match->team_ids);
        if ($match->status == 0) {
            foreach ($request->team_ids as $index => $id) {
                Team::where('id', $id)->update(['field_site' => $request->field_sites[$index]]);
            }
            $match->status = 1;
        } elseif ($match->status == 1) {
            $match->status = 2;
        } elseif ($match->status == 2) {
            foreach ($teams as $team) {
                $field_site = $team->field_site == 'Home' ? 'Away' : 'Home';
                Team::where('id', $team->id)->update(['field_site' => $field_site]);
            }
            $match->status = 3;
        } else {

            $winnerteam = $teams->where('id', $request->winner_team_id)->first();
            $loserteam = $teams->where('id', '!=', $request->winner_team_id)->first();
            $match->winner_team_id = $winnerteam->id;
            $match->loser_team_id = $loserteam->id;
            $match->status = 4;
        }
        $match->update();
        return redirect()->route('match.show', $match->slug)->with('message', 'Match status updated successfully');
    }
}
