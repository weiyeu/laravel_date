<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Create a new article controller instance.
     *
     */
    public function __construct()
    {
        // redirect if not auth
        $this->middleware('auth',[
            'only' => [
                'getEditArticle',
                'postEditArticle',
            ]
        ]);
    }

    /**
     * show the edit article form
     *
     * @return \Illuminate\Http\Response
     */
    public function getEditArticle(){
        return view('articles/edit_article');
    }

    /**
     * post the article to server
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postEditArticle(Request $request){

    }

    /**
     * show front page of forum
     *
     * @return \Illuminate\Http\Response
     */
    public function getForum(){
        return view('articles.forum');
    }

    /**
     * show the specific article
     *
     * @return \Illuminate\Http\Response
     */
    public function getArticle(){
        return view('articles.article');
    }
}
