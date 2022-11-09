<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'region_id', 'pin_code');
    protected $hidden = [
        'password', 'api_token'
    ];
    public function City()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notifications', 'notificationtable');
    }

    public function notificationtokens()
    {
        return $this->morphMany('App\Models\NotificationTokens', 'tokenable');
    }
    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
}
