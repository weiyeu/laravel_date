<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    protected $article_type_hash = [
        1 => '餐後心情',
        2 => '美食分享',
        3 => '美妙旋律',
        4 => '我想抒發',
        5 => '時尚潮流',
        6 => '隨便亂發',
    ];

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
        // get articles
        $articles = Article::orderBy('updated_at', 'desc')->take(10)->get();

        // return view with articles
        return view('articles.forum', [
            'articles' => $articles,
            'article_type_hash' => $this->article_type_hash,
        ]);
    }

    /**
     * show the specific article
     *
     * @return \Illuminate\Http\Response
     */
    public function getArticle($article_id)
    {
        // return specific article with article model
        return view('articles.article', [
            'article' => Article::whereId($article_id)->first(),
            'article_type_hash' => $this->article_type_hash,
        ]);
    }
}
