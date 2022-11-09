<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('content', 'notificationtable_id', 'notificationtable_type');

    public function notificationtable()
    {
        return $this->morphTo();
    }

}