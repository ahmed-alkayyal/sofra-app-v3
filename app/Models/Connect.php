<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connect extends Model 
{

    protected $table = 'connectes';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'message', 'type');

}