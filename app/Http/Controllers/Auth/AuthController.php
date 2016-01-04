<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Response;
use Validator;
use DB, Mail, Redirect, Session, App;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Library\ImageManipulator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */


    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $redirectPath = 'home';
    protected $loginPath = 'users/login';
    protected $failed_errors = '你在盜帳號嗎小垃圾?';
    protected $request;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->request = $request;
    }

//    public function getRegister()
//    {
//        return view('auth.register');
//    }
//
//    public function postRegister()
//    {
//        return redirect()->back();
//    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $message = [
            'nickName.required' => '暱稱不可以空白唷',
            'email.unique' => '電子信箱不可重複阿!!!',
            'password.confirmed' => '密碼確認不一致阿!!!',
        ];
        return Validator::make($data, [
            'nickName' => 'required|max:255',
            'realName' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:4',
        ], $message);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        // process uploaded image
        $path = $this->processUploadedImg($this->request);
        // generate confirmation code
        $confirmation_code = str_random(30);
        // create user
        $user = User::create([
            'nickname' => $data['nickName'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'real_name' => $data['realName'],
            'sex' => $data['sex'],
            'year' => $data['year'],
            'month' => $data['month'],
            'date' => $data['date'],
            'phone_number' => $data['phoneNumber'],
            'self_introduction' => $data['selfIntroduction'],
            'profile_image_path' => '',
            'confirmation_code' => $confirmation_code,
        ]);
        // confirmation code for mail
        $data = array(
            'confirmation_code' => $confirmation_code,
        );
        // remember to use cmd : 'php artisan queue:listen' to turn on the queue job function
        // mail to user through queue job
        Mail::queue('emails.email_verify', $data, function ($m) {
            $m->from('chenweiyeu@gmail.com', 'Learning Laravel');
            $m->to('chenweiyeu@gmail.com')->subject('Verify your mail');
        });
        return $user;
    }

    /**
     * Verify the user's email address by check confirmation code
     *
     * @param  String $confirmation_code
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function verifyMail($confirmation_code)
    {
        $user = User::whereconfirmation_code($confirmation_code)->first();
        // if user has been confirmed
        if (!$user) {
            return Redirect::to('home');
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();
        Session::flash('emailConfirmedMessage', 'Thanks for your email confirmation! You may login now :)');
        return Redirect::to('users/login');
    }

    /**
     * ajax check register Email is used or not
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxCheckEmail(Request $request)
    {
        // get input email
        $email = $request->input('email');
        // check email used or not
        $email_used = User::whereEmail($email)->count() > 0;
        // response data json
        $arr = array(
            'msg' => 'hello',
            'email' => $email,
            'used' => $email_used
        );
        return response()->json($arr);
    }

    protected function processUploadedImg(Request $request)
    {
        $destinationPath = "C:\\xampp\\htdocs\\laravel_date\\public\\resource\\profile_image";
        $file_name = uniqid("upload").'.jpg';
        $path = 'path is not set';
        if ($request->hasFile('uploadImg')) {
            $imgFile = $request->file('uploadImg');
            // check image file or not
            if(getimagesize($imgFile->getPathname()) !== false){
//                dd(getimagesize($imgFile->getPathname()));
            }else{
                dd(getimagesize($imgFile->getPathname()));
            }
            $path = $request->file('uploadImg')->move($destinationPath,$file_name);
        }
        return $path;
    }
}
