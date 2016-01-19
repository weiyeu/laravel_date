<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        // redirect if not auth
        $this->middleware('auth');
    }

    /**
     * Handle a registration request for the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEditArticle(){
        return view('articles/edit_article');
    }

    public function postEditArticle(){

    }
}
