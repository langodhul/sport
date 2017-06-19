<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admins extends Authenticatable
{
    protected $fillable = [
        'username', 'password','last_ip','creator','is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
