<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admins;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request)));

        $this->guard()->login($user);

        session(['ax'=> 'index']);
        session(['ay'=> 'home']);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function create($req)
    {
        $data = $req->all();
        return Admins::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'creator' => Auth::guard('admin')->check() ? Auth::guard('admin')->user()->username : 'admin',
            'last_ip' => $req->ip(),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        //
    }

    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}
