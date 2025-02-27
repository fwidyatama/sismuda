<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusCheck extends Model
{
    protected $table='bus_checks';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function getBusDetail($checkId){
        // dd(self::find($checkId)->toArray());
        $detailBus = self::find($checkId)->toArray();
        return $detailBus;
    }
}
