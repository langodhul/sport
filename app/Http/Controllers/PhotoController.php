<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Photos;

class PhotoController extends Controller
{

    public function photo()
    {
        $this->setBackstageSessionXY('photo', 'photo');
        $photos = Photos::where([])->orderBy('id', 'desc')->get();
        return view('backstage.createphoto', compact('photos'));
    }

    public function editForm($id)
    {
        $photo = Photos::find($id);
        return view('backstage.editphoto', compact('photo'));
    }

    public function createPhoto(Request $request)
    {
        $req = $request->all();
        $fail = Validator::make($req, [
            'title' => 'required|string',
            'photo' => 'required|image',
            'creator' => 'required|string',
            'priority' => 'required|numeric',
        ])->fails();
        if($fail)
        {
            return back()->with('message', '检查到某项数据错误或为空！');
        }
        $file = $request->file('photo');

        if($file)
        {
            $path = '/uploads/'.$file->store('pictures', 'uploads');
            if($path && Photos::create(['title' => $req['title'], 'creator' => $req['creator'], 'priority' => $req['priority'], 'descript' => $req['descript'], 'path' => $path]))
            {
                Cache::forever('photos', $this->getPhoto());
                return back()->with('message', '创建成功！');
            }
        }
        return back()->with('message', '上传照片失败！');
    }

    public function edit(Request $request)
    {
        $req = $request->all();
        switch ($req['type'])
        {
            case 'delete':
                if(Photos::find($req['id'])->delete())
                {
                    Cache::forever('photos', $this->getPhoto());
                    return back()->with('message', '删除成功！');
                }
                break;
            case 'isshow':
                $photo = Photos::find($req['id']);
                if($photo->is_show)
                {
                    $photo->is_show = 0;
                    if($photo->save())
                    {
                        Cache::forever('photos', $this->getPhoto());
                        return back()->with('message', '隐藏成功！');
                    }
                }else{
                    $photo->is_show = 1;
                    if($photo->save())
                    {
                        Cache::forever('photos', $this->getPhoto());
                        return back()->with('message', '显示成功！');
                    }
                }
            case 'changephoto':
                $file = $request->file('photo');
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
                    'title' => $req['title'],
                    'creator' => $req['creator'],
                    'descript' => $req['descript'],
                    'priority' => $req['priority'],
                    'path' => $req['path'],
                ];
                $validate = Validator::make($data, [
                    'title' => 'required|string',
                    'creator' => 'required|string',
                    'descript' => 'required|string',
                    'priority' => 'required|numeric',
                    'path' => 'required|string',
                ]);
                if($validate->fails())
                {
                    return back()->with('message', '检查到某项数据错误或为空！');
                }
                if(Photos::where('id', $req['id'])->update($data))
                {
                    Cache::forever('photos', $this->getPhoto());
                    return back()->with('message', '修改成功！');
                }
        }
        return back()->with('message', '操作失败！');
    }
}
