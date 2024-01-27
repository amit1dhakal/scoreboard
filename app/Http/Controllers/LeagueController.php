<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leagues = League::latest()->get();
        return view('admin.league.index', compact("leagues"));
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
        if(League::exists()){
            return redirect()->back()->withErrors('This system is for only one League');
        }
        $request->validate([
            'name' => 'required',
            'duration' => 'required',
        ]);
        $league = new League();
        $league->name = $request->name;
        $league->duration = $request->duration;
        $league->status = $request->status ?? 0;
        $league->save();
        return redirect()->route('league.index')->with('message', 'League is added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    public function show(League $league)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    public function edit(League $league)
    {
        return view('admin.league.edit', compact("league"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, League $league)
    {
        $request->validate([
            'name' => 'required',
            'duration' => 'required',
        ]);

        $league->name = $request->name;
        $league->duration = $request->duration;
        $league->status = $request->status ?? 0;
        $league->update();
        return redirect()->route('league.index')->with('message', 'League is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    public function destroy(League $league)
    {
        $league->delete();
        return redirect()->route('league.index')->with('message', 'League is deleted successfully');
    }
}
