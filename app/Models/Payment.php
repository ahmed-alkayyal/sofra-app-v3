<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model 
{

    protected $table = 'payments';
    public $timestamps = true;
    protected $fillable = array('payed', 'notes', 'payment_date', 'restaurant_id');

    public function restaurants()
    {
        return $this->hasMany('App\Models\Resturant');
    }

}