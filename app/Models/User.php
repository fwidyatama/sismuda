<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table='users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username','role','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


   public function role()
   {
       return $this->hasOne('App\Models\Role','id');
   }

   public function bus(){
       return $this->belongsToMany('App\Models\Bus');
   }

   public function workshop(){
       return $this->hasMany('App\Models\Workshop');
   }

   public function sparepart(){
       return $this->belongsToMany('App\Models\Sparepart','orders')
       ->withPivot('hull_code','sparepart_id','type','unit_name','price','quantity','date','status')
       ->withTimestamps();
   }

   public function buspermit(){
       return $this->hasOne('App\Models\BusPermit');
   }

   public function buscheck(){
       return $this->hasOne('App\Models\BusCheck');
   }


}
