<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\LeagueMatch;
use Illuminate\Console\Command;

class UpdateTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:time';

    protected $description = 'Update Match Time';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $matches  = LeagueMatch::whereIn('status', [1, 3])->get();
        foreach ($matches as $matchup) {
            $matchup->time  = $matchup->time + 1;
            $matchup->update();
            Helper::scoreboardupdate($matchup);
        }
    }
}
