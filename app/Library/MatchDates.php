<?php
/**
 * User: wei
 * Date: 2016/3/2
 * Time: 上午 12:22
 */

namespace App\Library;

use App\User;
use App\DateApplication;

class MatchDates
{

    public function __construct()
    {

    }

    public function test()
    {
        var_dump(User::where('id', 1)->first()->email);
    }

} 