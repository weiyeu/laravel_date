<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'web'], function () {

    // home
    Route::get('/{name}', 'PagesController@home')->where('name', '(home)*')->name('home');
    Route::get('/contact', 'TicketsController@create');
    Route::post('/contact', 'TicketsController@store');
    Route::get('/tickets', 'TicketsController@index');
    Route::get('/tickets/{slug}', 'TicketsController@show');
    Route::get('tickets/{slug}/edit', 'TicketsController@edit');
    Route::post('tickets/{slug}/edit', 'TicketsController@update');
    Route::post('tickets/{slug}/delete', 'TicketsController@destroy');
    Route::post('/comment', 'CommentsController@newComment');
    // users login/logout
    Route::get('auth/logout', 'Auth\AuthController@getLogout');
    Route::get('auth/login', 'Auth\AuthController@getLogin')->name('login');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
    Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');
    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');
    // users register
    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');
    // users ajax
    Route::post('users/ajax-check-input-used', 'Auth\AuthController@ajaxCheckInputUsed');
    Route::post('users/ajax-upload-image', 'ImageController@ajaxUploadImage');
    // verify user through verification link
    Route::get('register/verify/{confirmation_code}', 'Auth\AuthController@verifyMail');
    // profile
    Route::get('profile/edit', 'ProfileController@getProfile');
    Route::post('profile/edit', 'ProfileController@postProfile');
    Route::get('profile/change-password', 'ProfileController@getChangePassword');
    Route::post('profile/change-password', 'ProfileController@postChangePassword');
    // article
    Route::get('article/edit', 'ArticleController@getEditArticle');
    Route::post('article/edit', 'ArticleController@postEditArticle');
    Route::get('article/p/{article_id}', 'ArticleController@getArticle');
    Route::post('article/p/{article_id}', 'ArticleController@postComment');
    Route::get('forum', 'ArticleController@getForum');
    Route::get('article/intend/reply/{article_id}', 'ArticleController@intendedReply');
    Route::post('article/p/ajax-like/{article_id}', 'ArticleController@ajaxPostLike');
    Route::post('forum', 'ArticleController@searchArticle');
    // apply for date
    Route::get('apply_for_date','DateController@getApplyForDate');

    // test
    Route::get('chat','ChatController@getChat');
    Route::post('chat','ChatController@ajaxPostChat');


    Route::get('sendemail', function () {

        $data = array(
            'name' => "Learning Laravel",
        );

        Mail::send('tickets.welcome', $data, function ($message) {

            $message->from('chenweiyeu@gmail.com', 'Learning Laravel');

            $message->to('chenweiyeu@gmail.com')->subject('Learning Laravel test email');

        });
        return "Your email has been sent successfully";

    });

    Route::any('{slug}', 'PagesController@pageNotFound')->where('slug', '.*');

});

// Route::post('/contact', function(){
// 	$inputs = Input::all();
// 	$input_title = Input::get('title');
// 	$rules = ['title' => 'required|min:3', 'content' => 'required|min:10'];
// 	$messages = array('required'=>':attribute is required!!!');
// 	$validator = Validator::make($inputs,$rules,$messages);
// 	if($validator->passes()){
// 		return $inputs;
// 	}else{
// 		$data = ['title'=>$inputs['title'],'content'=>$inputs['content']];
// 		return Redirect::to('/contact')
// 		->with('title',$inputs['title'])
// 		->with('content',$inputs['content'])
// 		->withErrors($validator);
// 	}
// });

