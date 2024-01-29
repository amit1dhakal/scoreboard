<?php

namespace App\Helpers;

use App\Events\ScoreboardUpdate;
use App\Models\League;

class Helper
{
    static function randomText()
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 5);
    }
    static function league()
    {
        return League::first();
    }
    static function timeCorrection($time)
    {
        if (strlen($time) < 2) {
            $time = '0' . $time;
        }
        return  $time . ' : 00';
    }

    static function scoreboardupdate($match)
    {
        $lastevent = $match->allgoalfoul->first();
        try {
            $scoreboard = collect([
                'matchTime' => self::timeCorrection($match->time),
                'matchStatus' => $match->status,
                'slug' => $match->slug,
                'homeScore' => $match->goal->where('team_id', $match->home_team_id)->count() ?? 0,
                'awayScore' => $match->goal->where('team_id', $match->away_team_id)->count() ?? 0,
                'homeFoul' => $match->foul->where('team_id', $match->home_team_id)->count() ?? 0,
                'awayFoul' => $match->foul->where('team_id', $match->away_team_id)->count() ?? 0,
                'lastEvent' => $lastevent? 'Last '. $lastevent->type.' by '. $lastevent->player->name .' ( '. $lastevent->player->jersey_no. ' ) at '.$lastevent->event_time.' minutes for '. $lastevent->team->name : 0,
            ]);
            event(new ScoreboardUpdate($scoreboard));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    static function leagueStatus()
    {
        $league = self::league();
        $message = '';
        if (empty($league)) {
            $message = 'League is not Added';
        } elseif ($league->status == 0) {
            $message = 'League is not Stated';
        } elseif ($league->status == 1) {
            $message = 'League is Running';
        } else {
            $message = 'League is End';
        }
        return $message;
    }
}
