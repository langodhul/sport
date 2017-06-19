<?php

namespace App\Http\Controllers\Admin;

use App\Admins;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function adminList()
    {
        session(['bx'=> 'admin']);
        session(['by'=> 'adminlist']);
        $admins = Admins::paginate(8);
        return view('backstage.adminlist',compact('admins'));
    }

    public function adminForm()
    {
        session(['bx'=> 'admin']);
        session(['by'=> 'adminform']);
        return view('backstage.adminform');
    }

    public function createAdmin(Request $request)
    {
        $this->validator($request->all())->validate();

        if($this->create($request))
        {
            return back()->with('message',$request->all()['username'].' 创建成功！');
        }else{
            return back()->with('message',$request->all()['username'].' 创建失败！');
        }
    }

    public function deleteAdmin($id)
    {
        $admin = Admins::find($id);
        if ($admin && $admin->username != 'admin' && $admin->is_active == 0)
        {
            $admin->delete();
            echo false;
        }else{
            echo '此管理员还在启用状态';
        }
    }

    public function activeAdmin($id)
    {
        $admin = Admins::find($id);
        if ($admin && $admin->username != 'admin')
        {
            if($admin->is_active){
                $admin->is_active = 0;
                echo '禁用中';
            }else{
                $admin->is_active = 1;
                echo '启用中';
            }
            $admin->save();
        }
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
}
