<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'last_name', 'email', 'phone', 'verified', 'photo', 'password', 'remember_token'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['fullname'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','remember_token'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;


    /**
     * @return string
     */
    public function getFullnameAttribute()
    {
        return $this->attributes[ "name" ] . " " . $this->attributes[ "last_name" ];
    }

    /**
     * @param $query
     * @param $email
     * @return mixed
     */
    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

}
