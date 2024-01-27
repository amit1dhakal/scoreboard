<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TeamController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::latest()->get();
        return view('admin.team.index', compact("teams"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       if(@Helper::league()->status!=0 ){
            return redirect()->route('league.index')->withErrors('League is not created or already started');
        } else {

            $teams = Team::pluck('player_ids');
            $player_ids  = Arr::flatten($teams);
            $players = Player::whereNotIn('id', $player_ids)->latest()->get();
            if (count($players) < 1) {
                return redirect()->route('player.index')->withErrors('Player is not Available');
            }
            return view('admin.team.create', compact("players"));
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
        $request->validate([
            'name' => 'required',
            'player_ids' => 'required',
        ], ['player_ids.requred' => 'Pls select the players']);
        // return $request;
        $team = new Team();
        $team->name = $request->name;
        $team->player_ids = $request->player_ids;
        $team->save();
        return redirect()->route('team.index')->with('message', 'Team created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        if(@Helper::league()->status!=0 ){
            return redirect()->route('league.index')->withErrors('League is not created or already started');
        } else {

            $exists_teams = Team::where('id','!=',$team->id)->pluck('player_ids');
            $player_ids  = Arr::flatten($exists_teams);
            $players = Player::whereNotIn('id', $player_ids)->latest()->get();
            if (count($players) < 1) {
                return redirect()->route('player.index')->withErrors('Player is not Available');
            }

            return view('admin.team.edit', compact("players", "team"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required',
            'player_ids.*' => 'required',
        ]);

        $team->name = $request->name;
        $team->player_ids = $request->player_ids;
        $team->update();
        return redirect()->route('team.index')->with('message', 'Team updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('team.index')->with('message', 'Team deleted successfully');
    }
}
