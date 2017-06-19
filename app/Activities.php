<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $fillable = ['title', 'content', 'creator', 'is_show', 'descript'];
}
