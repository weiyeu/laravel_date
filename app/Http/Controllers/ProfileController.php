<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\ImageProcessor;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;

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
     * Display a user's change password
     *
     * @return \Illuminate\Http\Response
     */
    public function getChangePassword()
    {
        return view('profile.change_password');
    }


    /**
     * change a user's password
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postChangePassword(Request $request)
    {
        // get current user
        $user = auth()->user();

        // validate form
        $this->validate($request,
            [
                'old_password' => 'required|min:4',
                'new_password' => 'required|min:4|confirmed',
            ],
            [
                'old_password.required' => '舊密碼不可以空白唷',
                'new_password.required' => '新密碼不可以空白唷',
                'new_password.confirmed' => '新密碼兩次輸入不一致唷',
            ]);

        // check old password
        if(!Hash::check($request->input('old_password'),$user->password)){
            return back()->withErrors('舊密碼不正卻唷');
        }

        // update new password
        $user->update([
           'password' => bcrypt($request->input('new_password')),
        ]);

        return back()->with('success', '密碼更換成功');
    }

}
