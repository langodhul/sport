<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coaches extends Model
{
    protected $fillable = ['name', 'classify_id', 'synopsis', 'rect_picture', 'square_picture', 'is_show', 'descript'];
    
}
