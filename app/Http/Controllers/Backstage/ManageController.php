<?php

namespace App\Http\Controllers\Backstage;

use App\Login_logs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageController extends Controller
{
    public function home()
    {
        session(['bx'=> 'index']);
        session(['by'=> 'home']);
        $logs = Login_logs::paginate(8);
        return view('backstage/home',compact('logs'));
    }

}
