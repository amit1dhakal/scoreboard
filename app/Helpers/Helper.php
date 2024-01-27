<?php

namespace App\Helpers;

use App\Models\League;

class Helper{
    static function randomText()
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 5);
    }
    static function league()
    {
        return League::first();
    }

   
}