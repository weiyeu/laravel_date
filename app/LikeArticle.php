<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeArticle extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the article that owns the comment.
     */
    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
