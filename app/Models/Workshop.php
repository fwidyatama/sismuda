<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    
    // protected $fillable = ['user_id','hull_code','order_date','work_type','note'];
    protected $fillable = ['user_id','workshop_number','hull_code','order_date','work_type','note'];
    public function user(){
        return $this->belongsToMany('App\Models\User');
    }

    public function bus(){
        return $this->belongsToMany('App\Models\Bus');
    }

}
