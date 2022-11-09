<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTokens extends Model 
{

    protected $table = 'notification_tokens';
    public $timestamps = true;
    protected $fillable = array('token', 'tokenable_id', 'tokenable_type');

}