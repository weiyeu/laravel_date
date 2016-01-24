<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id','likes','comments'];

    /**
     * Get the user that owns the article.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the comments that the article has.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the likes that the article has.
     */
    public function likeArticles()
    {
        return $this->hasMany('App\LikeArticle');
    }
}
