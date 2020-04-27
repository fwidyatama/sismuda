<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    //
    protected $table="buses";
    protected $primaryKey = "hull_code";

    public function user(){
        return $this->belongsToMany('App\Models\User','workshops','hull_code','user_id')
        ->withPivot('order_date','note','work_type','note')
        ->withTimestamps();
    }
    
    
}
