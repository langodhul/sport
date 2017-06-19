<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site_configs extends Model
{
    protected $fillable = ['name', 'value', 'value2', 'value3'];

    public $timestamps = false;
}
