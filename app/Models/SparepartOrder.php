<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparepartOrder extends Model
{
    protected $table='orders';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','hull_code','sparepart_id','type','date','quantity','unit_name','status'];

    public function user(){
        return $this->belongsToMany('App\Models\User');
    }
}
