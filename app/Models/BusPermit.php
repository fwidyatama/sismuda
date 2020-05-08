<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusPermit extends Model
{
    protected $table='bus_permits';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
