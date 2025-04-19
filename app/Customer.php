<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'first_name', // Cambia 'name' por 'first_name'
        'last_name',
        'address',
        'phone',
        'email',
        'verified',
        'password',
        'remember_token'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function establishments()
    {
        return $this->hasMany(Establishment::class, 'customer_id');
    }


    /**
     * @return string
     */
    public function getFullnameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name; // Usa first_name
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
