<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $withgoals = Player::with(['team:id,name'])->withCount('goal')
                ->orderBy('goal_count', 'desc')
                ->limit(5)->get();
       $withfouls = Player::with('team:id,name')->withCount('foul')
                ->orderBy('foul_count', 'desc')
                ->limit(5)->get();
        return view('admin.index',compact("withgoals","withfouls"));
    }
}
