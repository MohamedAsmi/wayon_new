<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Owner extends Authenticatable
{
    use Notifiable;
    const  IS_OWNER = 2;
    protected $table    = 'owners';

    protected $fillable = ['username', 'email', 'password'];

    protected $hidden   = ['password', 'remember_token'];

    public function getProfileSrcAttribute()
    {
        if ($this->attributes['profile_image'] == '') {
            $src = url('public/images/user_pic.jpg');
        } else {
            $src = url('public/images/profile/'.$this->attributes['id'].'/'.$this->attributes['profile_image']);
        }

        return $src;
    }

    public function ownerverification()
    {
        return $this->hasOne('App\Models\OwnerVerification', 'owner_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany('App\Models\Properties', 'host_id', 'id');
    }

}
