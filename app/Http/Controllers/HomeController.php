<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\LeagueMatch;
use App\Models\Player;
use App\Models\Team;
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
    public function index(Request $request)
    {
        $withgoals = Player::with(['team:id,name'])->withCount('goal')
            ->orderBy('goal_count', 'desc')
            ->limit(5)->get();
        $withfouls = Player::with('team:id,name')->withCount('foul')
            ->orderBy('foul_count', 'desc')
            ->limit(5)->get();
        $teams = Team::get(['id', 'name']);
        $selectedteams = [];
        $goals = [];
        if ($request->team_1 && $request->team_2) {
            if ($request->team_1 == $request->team_2) {
                return redirect()->back()->withErrors('First team and second team must not same');
            }
            $selectedteams = Team::whereIn('id', [$request->team_1, $request->team_2])->get(['id', 'name']);
            $totalMatches = LeagueMatch::where(function ($query) use ($request) {
                $query->where('home_team_id', $request->team_1)->where('away_team_id', $request->team_2);
            })->orWhere(function ($query) use ($request) {
                $query->where('home_team_id', $request->team_2)->where('away_team_id', $request->team_1);
            })->pluck('id');
            $goals = Goal::whereIn('match_id', $totalMatches)->get();
        }

        $old_values = collect(['team_1' => $request->team_1, 'team_2' => $request->team_2]);
        return view('admin.index', compact("withgoals", "withfouls", "teams", "old_values", "goals", "selectedteams"));
    }

    public function teamfilter()
    {
        return response()->json(Team::where('id', '!=', request()->id)->get(['id', 'name']));
    }
}
