<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Customers;

class CustomerController extends Controller
{
    public function index()
    {
        $this->setBackstageSessionXY('customer', 'customer');
        $customers = Customers::where([])->orderBy('id', 'desc')->get();

        return view('backstage.customer', compact('customers'));
    }

    public function create(Request $request)
    {
        $req = $request->all();
        $fail = Validator::make($req, [
            'name' => 'required|string',
            'picture' => 'required|image',
            'url' => 'required|string',
            'priority' => 'required|numeric',
        ])->fails();
        if($fail)
        {
            return back()->with('message', '检查到某项数据错误或为空！');
        }
        $file = $request->file('picture');

        if($file)
        {
            $path = '/uploads/'.$file->store('pictures', 'uploads');
            if($path && Customers::create(['name' => $req['name'], 'url' => $req['url'], 'priority' => $req['priority'], 'path' => $path]))
            {
                Cache::forever('customers', $this->getCustomer());
                return back()->with('message', '创建成功！');
            }
        }
        return back()->with('message', '图片上传失败！');
    }

    public function edit(Request $request)
    {
        $req = $request->all();
        switch ($req['type'])
        {
            case 'delete':
                if(Customers::find($req['id'])->delete())
                {
                    Cache::forever('customers', $this->getCustomer());
                    return back()->with('message', '删除成功！');
                }
                break;
            case 'isshow':
                $customer = Customers::find($req['id']);
                if($customer->is_show)
                {
                    $customer->is_show = 0;
                    if($customer->save())
                    {
                        Cache::forever('customers', $this->getCustomer());
                        return back()->with('message', '隐藏成功！');
                    }
                }else{
                    $customer->is_show = 1;
                    if($customer->save())
                    {
                        Cache::forever('customers', $this->getCustomer());
                        return back()->with('message', '显示成功！');
                    }
                }
                break;
            case 'changepicture':
                $file = $request->file('picture');
                if($file)
                {
                    if($path = '/uploads/'.$file->store('pictures', 'uploads'))
                    {
                        return Response::json([
                            'code' => 1,
                            'path' => $path,
                            'href' => url($path),
                            'msg' => '照片上传成功！',
                        ]);
                    }
                }
                return Response::json([
                    'code' => 0,
                    'msg' => '照片上传失败！',
                ]);
            case 'update':
                $data = [
                    'name' => $req['name'],
                    'url' => $req['url'],
                    'priority' => $req['priority'],
                    'path' => $req['path'],
                ];
                $validate = Validator::make($data, [
                    'name' => 'required|string',
                    'url' => 'required|string',
                    'priority' => 'required|numeric',
                    'path' => 'required|string',
                ]);
                if($validate->fails())
                {
                    return back()->with('message', '检查到某项数据错误或为空！');
                }
                if(Customers::where('id', $req['id'])->update($data))
                {
                    Cache::forever('customers', $this->getCustomer());
                    return back()->with('message', '修改成功！');
                }
        }
        return back()->with('message', '操作失败！');
    }

    public function editForm($id)
    {
        $customer = Customers::find($id);

        return view('backstage.editcustomer', compact('customer'));
    }
}
