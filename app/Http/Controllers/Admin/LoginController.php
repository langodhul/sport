<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use App\Admins;
use App\Login_logs;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/backstage';

    protected $username;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->loginLog(['username' => $request->get('username'), 'ip' => $request->ip(), 'result' => 0, 'comment' => '限制登陆10分钟']);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $this->updateInfo($request);
            $this->setBackstageSessionYX('home');
            $this->loginLog(['username' => $request->get('username'), 'ip' => $request->ip(), 'result' => 1, 'comment' => '登陆成功']);
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->loginLog(['username' => $request->get('username'), 'ip' => $request->ip(), 'result' => 0, 'comment' => '登陆失败']);

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = array_merge($this->credentials($request),['is_active' => 1]);

        return $this->guard()->attempt(
            $credentials, $request->has('remember')
        );
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function username()
    {
        return 'username';
    }

    protected function updateInfo(Request $request)
    {
        $data = $request->all();
        Admins::where('username',$data['username'])
            ->update(['last_ip' => $request->ip()]);
    }

    protected function setBackstageSessionYX($y, $x = 'index')
    {
        session(['bx'=> $x]);
        session(['by'=> $y]);
    }

    protected function loginLog($data)
    {
        Login_logs::create($data);
    }
}
