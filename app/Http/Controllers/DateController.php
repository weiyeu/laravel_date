<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DateController extends Controller
{
    /**
     * Create a new DateController instance.
     *
     */
    public function __construct()
    {
        // redirect if not auth
        $this->middleware('auth', [
            'only' => [
                'getApplyForDate',
            ]
        ]);
    }

    /**
     * show the apply form
     */
    public function getApplyForDate()
    {
        return view('apply_for_date');
    }

    public function postApplyForDate(Request $request){

    }
}
