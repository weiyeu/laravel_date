<?php

namespace App\Http\Controllers;

use App\LikeArticle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use App\Comment;

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
                'intendedReply',
                'postComment',
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
     * @param int $article_id
     * @return \Illuminate\Http\Response
     */
    public function getArticle($article_id)
    {
        // check the user has liked it or not
        // temp liked variable
        $liked = null;
        //-- get article
        $article = Article::whereId($article_id)->first();
        //-- get current user
        $user = auth()->user();
        // user has liked, return liked response
        if ($article->likeArticles()->whereUser_id($user->id)->first()) {
            $liked = 'liked';
        };

        // return specific article with article model
        return view('articles.article', [
            'article' => Article::whereId($article_id)->first(),
            'article_type_hash' => $this->article_type_hash,
            'article_id' => $article_id,
            'user' => auth()->user(),
            'liked' => $liked,
        ]);
    }

    /**
     * user try to reply article without authentication
     *
     * @param int $article_id
     * @return Response
     */
    public function intendedReply($article_id)
    {
        // if user is authenticated, redirect to the previous page
        return redirect('article/p/' . $article_id);
    }

    /**
     * post comment to article
     *
     * @param Request $request
     * @param int $article_id
     * @return Response
     */
    public function postComment(Request $request, $article_id)
    {
        // increment article number of comments
        $article = Article::whereId($article_id)->first();
        $article->update([
            'num_of_comments' => $article->num_of_comments + 1,
        ]);

        // create comment
        Comment::create([
            'user_id' => auth()->user()->id,
            'article_id' => $article_id,
            'comment_content' => $request->input('comment_content'),
        ]);

        // return the same page
        return back();
    }

    /**
     * ajax post like to article
     *
     * @param Request $request
     * @param int $article_id
     * @return Response
     */
    public function ajaxPostLike(Request $request, $article_id)
    {
        // check authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'user is not authenticated']);
        }

        // check the user has liked it or not
        // temp plus variable
        $plus = 1;
        //-- get article
        $article = Article::whereId($article_id)->first();
        //-- get current user
        $user = auth()->user();
        // user has liked, decrement num_of_likes
        if ($article->likeArticles()->whereUser_id($user->id)->first()) {
            $plus = -1;
        };


        // determine to create LikeArticle or deleted liked record
        if ($plus == 1) {
            LikeArticle::create([
                'user_id' => $user->id,
                'article_id' => $article_id,
            ]);
        } else {
            LikeArticle::whereUser_id($user->id)->whereArticle_id($article_id)->first()->delete();
        }

        // increment number of likes
        $article->update([
            'num_of_likes' => $article->num_of_likes + $plus,
        ]);

        return response()->json(['num_of_likes' => $article->num_of_likes]);

    }

}
