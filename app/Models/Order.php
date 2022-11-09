<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('client_id', 'total_price', 'state', 'restaurant_id', 'payment_id', 'note','address','price');

    public function orderdetails()
    {
        return $this->hasMany('App\Models\OrderDetails');
    }
    public function items()
    {
        return $this->belongsToMany('App\Models\Item')->withPivot('quantity','additions','price');
    }
    public function orders(){
        return $this->belongsTo('App\Models\Client');
    }
}
