<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    protected $table = 'mutates';

    protected $fillable = ['user_id','sparepart_id','status','date','quantity','unit_name','price','type'];

}
