<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model 
{

    protected $table = 'comments';
    public $timestamps = true;
    protected $fillable = array('client_id', 'comment', 'restaurant_id', 'emoji');

    public function clientComment()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function commentrestaurant()
    {
        return $this->hasMany('App\Models\Resturant');
    }

}