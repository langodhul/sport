<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $fillable = ['title', 'descript', 'creator', 'priority', 'is_show', 'views', 'path'];
}
