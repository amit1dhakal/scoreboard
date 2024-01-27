<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::latest()->get();
        return view('admin.player.index', compact("players"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return back();
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
            'jersey_no' => 'required|unique:players',
        ]);
        $player = new Player();
        $player->name = $request->name;
        $player->jersey_no = $request->jersey_no;
        $player->save();
        return redirect()->route('player.index')->with('message', 'Player added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        if (@Helper::league()->status != 0) {
            return redirect()->route('league.index')->withErrors('League is not created or already started');
        } else {
            return view('admin.player.edit', compact('player'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        $request->validate([
            'name' => 'required',
            'jersey_no' => 'required|unique:players,jersey_no,' . $player->id,
        ]);
        $player->name = $request->name;
        $player->jersey_no = $request->jersey_no;
        $player->update();
        return redirect()->route('player.index')->with('message', 'Player updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        $player->delete();
        return redirect()->route('player.index')->with('message', 'Player deleted successfully');
    }
}
