<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;
    protected $table = 'regions';
    public $timestamps = true;
    protected $fillable = array('name', 'city_id');

    public function ClientsCity()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function governorate()
    {
        return $this->belongsTo('App\Models\City');
    }

}
