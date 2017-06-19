<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Knowledges extends Model
{
    protected $fillable = ['title', 'content', 'creator', 'is_show', 'descript'];
}
