<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusPermit extends Model
{
    protected $table='bus_permits';

    protected $fillable = ['hull_code','user_id','workshop_number','note','date'];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
