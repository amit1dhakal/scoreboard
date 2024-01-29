<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Player;
use App\Models\Team;
use App\Models\TeamPlayer;
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
        $teams = Team::with('player')->withCount('goal')->latest()->get();
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

             $teams = TeamPlayer::pluck('player_id');
            // $player_ids  = Arr::flatten($teams);
            $players = Player::whereNotIn('id',$teams)->latest()->get();
            if (count($players) < 1) {
                return redirect()->route('team.index')->withErrors('Player is not Available');
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
        $team->save();
        $team->player()->attach($request->player_ids);

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

            $teams = TeamPlayer::where('team_id','!=',$team->id)->pluck('player_id');
            // $player_ids  = Arr::flatten($exists_teams);
            $players = Player::whereNotIn('id', $teams)->latest()->get();
            if (count($players) < 1) {
                return redirect()->route('team.index')->withErrors('Player is not Available');
            }
             $selectedplayers = $team->player->pluck('id');
            //  $selectedplayers =  ;
            //  $selectedplayers = TeamPlayer::where('team_id', $team->id)->latest()->pluck('player_id');
            // $selectedplayers = [1,2];
            return view('admin.team.edit', compact("players", "team","selectedplayers"));
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
       
        $team->update();
        TeamPlayer::where('team_id',$team->id)->delete();
        $team->player()->attach($request->player_ids);
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
