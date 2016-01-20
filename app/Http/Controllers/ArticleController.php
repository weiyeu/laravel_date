<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    /**
     * Create a new article controller instance.
     *
     */
    public function __construct()
    {
        // redirect if not auth
        $this->middleware('auth', [
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
    public function getEditArticle()
    {
        return view('articles/edit_article');
    }

    /**
     * post the article to server
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postEditArticle(Request $request)
    {
        // validate input
        $this->validate($request,
            [
                'title' => 'required',
                'article_content' => 'required',
                'article_type' => 'required',
            ],
            [
                'title.required' => '標題不可以空白唷',
                'article_content.required' => '內文不可以空白唷',
                'article_type.required' => '記得要選擇文章分類唷',
            ]);

        // get input array
        $inputAll = $request->all();

        // get current user id
        $user_id = auth()->user()->id;

        // create article
        $article = Article::create([
            'user_id' => $user_id,
            'title' => $inputAll['title'],
            'article_content' => $inputAll['article_content'],
            'article_type' => $inputAll['article_type'],
        ]);

        // redirect to forum
        return redirect('forum');
    }

    /**
     * show front page of forum
     *
     * @return \Illuminate\Http\Response
     */
    public function getForum()
    {
        return view('articles.forum');
    }

    /**
     * show the specific article
     *
     * @return \Illuminate\Http\Response
     */
    public function getArticle()
    {
        return view('articles.article');
    }
}
