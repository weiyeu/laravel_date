<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use DB,Mail,Redirect,Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

    protected $loginPath = 'users/login';
    protected $failed_errors = '你在盜帳號嗎小垃圾?';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'unique' => '電子信箱不可重複阿!!!'
        ];
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
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
        $confirmation_code = str_random(30);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => $confirmation_code,
        ]);

        $data = array(
            'confirmation_code' => $confirmation_code,
        );

        Mail::send('emails.email_verify',$data,function($m){
            $m->from('chenweiyeu@gmail.com','Learning Laravel');
            $m->to('chenweiyeu@gmail.com')->subject('Verify your mail');
        });
        return $user;
    }
    protected function verifyMail($confirmation_code){
        $user = User::whereconfirmation_code($confirmation_code)->first();
        // if user has been confirmed
        if(!$user){
            return Redirect::to('home');
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();
        Session::flash('emailConfirmedMessage','Thanks for your email confirmation! You may login now :)');
        return Redirect::to('users/login');
    }
}
