<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Response;
use Validator;
use DB, Mail, Redirect, Session, App, Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Library\ImageManipulator;
use App\Library\ImageProcessor;

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


    use AuthenticatesAndRegistersUsers, ThrottlesLogins, ImageProcessor;
    protected $redirectPath = 'users/login';
    protected $loginPath = 'users/login';
    protected $failed_errors = '你在盜帳號嗎小垃圾?';
    protected $request;

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct(Request $request)
    {
        // redirect if not guest
        $this->middleware('guest', ['except' => 'getLogout']);

        // image check
        $this->middleware('image', ['only' => 'postRegister']);

        // get request
        $this->request = $request;
    }

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
            'nickName.unique' => '暱稱已經被使用了!!!',
            'email.unique' => '電子信箱不可重複阿!!!',
            'password.confirmed' => '密碼確認不一致阿!!!',
        ];
        return Validator::make($data, [
            'nickName' => 'required|max:255|unique:users',
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
            'profile_image_path' => $data['profile_image_url'],
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
     * @Override
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        //-- crop profile image --
        // temp vars
        $profile_image_url = null;

        // check has uploadImg or not
        if ($request->hasFile('uploadImg')) {

            // crop profile image
            $profile_image_url = $this->cropImage(
                $request->file('uploadImg')->getPathname(),
                'profile_image',
                json_decode($request->input('jcropSelection'),true)
            )['imgUrl'];

        } // no uploadImg
        else {
            $profile_image_url = null;
        }

        // create user
        $this->create(array_merge($request->all(), ['profile_image_url' => $profile_image_url]));

        return redirect($this->redirectPath())->with('goToConfirmEmail', '記得去信箱確認連結才可以成功登入了唷');
    }

    /**
     * @Override
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
        // add by WeiYeu to check user confirmed or not
        $credentials['confirmed'] = true;

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
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
//        Session::flash('emailConfirmedMessage', 'Thanks for your email confirmation! You may login now :)');
        return redirect('users/login')->with('emailConfirmedMessage', '感謝您的申請，現在可以登入了唷');
    }

    /**
     * ajax check register input data is used or not
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxCheckInputUsed(Request $request)
    {
        // get input under check
        $inputUnderCheck = $request->input('inputUnderCheck');
        // get input type
        $inputName = $request->input('inputName');
        // check email used or not
        $used = User::where($inputName, $inputUnderCheck)->count() > 0;
        // response data json
        $arr = array(
            'msg' => 'hello',
            'input' => $inputUnderCheck,
            'used' => $used
        );
        return response()->json($arr);
    }

    protected function processUploadedImg(Request $request)
    {
        $destinationPath = "C:\\xampp\\htdocs\\laravel_date\\public\\resource\\profile_image";
        $file_name = date('Y-m-d-H-i-s') . uniqid("upload") . '.jpg';
        $path = 'path is not set';
        if ($request->hasFile('uploadImg')) {
            $imgFile = $request->file('uploadImg');
            // instance imageManipulator
            $imageManipulator = new ImageManipulator($imgFile->getPathname());
            // check image file or not
            $imgArray = getimagesize($imgFile->getPathname());
            if ($imgArray !== false) {
                dd($imgArray);
            } else {
                dd($imgArray);
            }
            $path = $request->file('uploadImg')->move($destinationPath, $file_name);
        }
        return $path;
    }
}
