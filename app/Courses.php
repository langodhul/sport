<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $fillable = ['name', 'english_name', 'url', 'describe', 'picture_url', 'is_show'];
}
