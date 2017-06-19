<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
//    protected $fillable = ['name', 'path' ,'url', 'priority', 'is_show'];
    protected $guarded = ['id'];
}
