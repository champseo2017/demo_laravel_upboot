<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;




class User extends Model implements AuthenticatableContract
{
    use Authenticatable,CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function domains()
    {
        return $this->belongsToMany('App\Model\domain','domainkeys')->withTimestamps();

    }


    public function domainss()
    {
        return $this->belongsToMany('App\Model\domain','domainkeys');

    }

   
   



   

   
}
