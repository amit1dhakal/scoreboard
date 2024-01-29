<?php

namespace App\Http\Controllers;

use App\Events\ScoreboardUpdate;
use App\Models\LeagueMatch;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(){
       $matches = LeagueMatch::with(['hometeam','awayteam','winnerteam','referee'])->latest()->orderby('status','asc')->get();
       return view('client.index',compact("matches"));
    }
    public function show($slug){
       
        $match = LeagueMatch::whereIn('status',[1,2,3])->with(['hometeam', 'awayteam', 'goal'])->where('slug', $slug)->firstOrFail();
        return view('client.show', compact("match"));
    }
}
