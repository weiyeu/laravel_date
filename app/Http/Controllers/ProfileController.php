<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\ImageProcessor;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    use ImageProcessor;

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct(Request $request)
    {
        // redirect if not auth
        $this->middleware('auth');

        // image check
        $this->middleware('image', ['only' => 'postProfile']);
    }

    /**
     * Display a user's profile
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfile()
    {

        return view('profile.profile');
    }

    /**
     * update a user's profile
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postProfile(Request $request)
    {
        // get current user
        $user = auth()->user();

        // validate form
        $this->validate(
            $request,
            [
                'nickName' => 'required|max:255|unique:users,nickname,' . $user->id,
                'realName' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'sex' => 'required',
                'year' => 'required',
                'month' => 'required',
                'date' => 'required',
            ],
            [
                'nickName.required' => '暱稱不可以空白唷',
                'email.required' => '電子信箱不可空白唷',
                'sex.required' => '性別不可以空白唷',
                'year.required' => '出生年不可空白唷',
                'month.required' => '出生月不可空白唷',
                'date.required' => '出生日不可空白唷',
            ]);

        //-- crop profile image --
        // temp vars
        $profile_image_url = null;

        // check has uploadImg or not
        if ($request->hasFile('uploadImg')) {

            // crop profile image
            $profile_image_url = $this->cropImage(
                $request->file('uploadImg')->getPathname(),
                'profile_image',
                json_decode($request->input('jcropSelection'), true)
            )['imgUrl'];

        } // no uploadImg
        else {
            $profile_image_url = null;
        }

        //-- update profile data --
        $data = $request->all();
        $user->update([
            'nickname' => $data['nickName'],
            'email' => $data['email'],
            'real_name' => $data['realName'],
            'sex' => $data['sex'],
            'year' => $data['year'],
            'month' => $data['month'],
            'date' => $data['date'],
            'phone_number' => $data['phoneNumber'],
            'self_introduction' => $data['selfIntroduction'],
            'profile_image_path' => $profile_image_url,
        ]);

        // return the same page
        return back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
