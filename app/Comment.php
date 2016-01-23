<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id','likes'];

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
