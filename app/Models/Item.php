<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $table = 'items';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'image', 'restaurant_id', 'price','order_time');

    public function ItemRestaurant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }
    // public function restaurant()
    // {
    //     return $this->hasMany('App\Models\Resturant');
    // }
}
