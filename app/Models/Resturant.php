<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resturant extends Model
{

    protected $table = 'restaurants';
    public $timestamps = true;
    const STATUS_OPEN=1;
    const STATUS_CLOSE=2;
    protected $fillable = array('name', 'image', 'status', 'email', 'phone', 'password', 'minimum_order', 'mobile', 'delivery', 'whatsapp', 'region_id', 'pin_code');

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notifications', 'notificationtable');
    }

    public function notificationtokens()
    {
        return $this->morphMany('App\Models\NotificationTokens', 'tokenable');
    }

    public function payment()
    {
        return $this->belongsTo('App\Models\Payment');
    }

}
