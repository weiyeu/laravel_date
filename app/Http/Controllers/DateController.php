<?php

namespace App\Http\Controllers;

use App\DateApplication;
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
                'postApplyForDate',
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

    /**
     * post apply form
     *
     * @param Request $request
     * @return Response
     */
    public function postApplyForDate(Request $request)
    {
        // validate input
        $this->validate($request,
            [
                'city' => 'required',
                'start_time' => 'required|integer',
                'end_time' => 'required|integer',
                'vegetarian_type' => 'required|in:是,否,我都可以唷',
                'meal_type' => 'required|in:中餐,西餐,我都可以唷',
//                'sex_constraint' => 'required',
            ],
            [
                'city.required' => '用餐城市不可以空白唷',
                'start_time.required' => '用餐開始時間不可以空白唷',
                'end_time.required' => '用餐結束時間不可以空白唷',
            ]);

        // get input array
        $inputAll = $request->all();

        // append user id input input array
        $inputAll['user_id'] = auth()->user()->id;

        // create date application
        $dateApplication = DateApplication::create($inputAll);

        // show application success page
        return redirect('home');

    }
}
