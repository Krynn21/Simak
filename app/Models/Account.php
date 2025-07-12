<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    protected $fillable = ['username', 'password'];

    protected $hidden = ['password'];

    protected $table = 'users';

    // Jika kamu tidak pakai "remember_token", bisa nonaktifkan:
    public $remember_token = false;
    function setPasswordAttribute($value)
{
    $this->attributes['password'] = bcrypt($value);
}
}



