<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Workshop extends Model
{
    
    // protected $fillable = ['user_id','hull_code','order_date','work_type','note'];
    protected $fillable = ['hull_code','user_id','order_date','workshop_number','note','work_type','status'];
    protected $table = 'workshops';
    
    public function user(){
        return $this->belongsToMany('App\Models\User');
    }

    public function bus(){
        return $this->belongsToMany('App\Models\Bus');
    }

    
    public function changeStatus($workshopNumber){
        DB::table('workshops')
        ->where('workshop_number','like',$workshopNumber)
        ->update(['status' => 1]);
    }

}
