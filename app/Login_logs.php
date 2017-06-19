<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login_logs extends Model
{
    protected $fillable = ['username', 'ip', 'result', 'comment'];
}
