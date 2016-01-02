<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ticket
 *
 */
class Ticket extends Model
{
    protected $guarded = ['id'];

    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id');
//        return Comment::where('post_id',$this->id)->first()->content;
    }
}
