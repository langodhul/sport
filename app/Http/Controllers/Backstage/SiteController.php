<?php

namespace App\Http\Controllers\Backstage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Site_configs;
use App\Site_navigations;

class SiteController extends Controller
{
    public function siteConfig()
    {
        session(['bx'=> 'web']);
        session(['by'=> 'siteconfig']);
        Cache::forever('configs', $this->getSiteConfig());
        $configs = Cache::rememberForever('configs', function (){
            return $this->getSiteConfig();
        });
        return view('backstage.siteconfig', compact('configs'));
    }

    public function saveConfig(Request $request)
    {
        $this->validator($request->all())->validate();

        if($this->save($request))
        {
            Cache::forever('configs', $this->getSiteConfig());
            return back()->with('message', '保存成功！');
        }

        return back()->with('message', '保存失败！');

    }

    public function friendShip()
    {
        $this->setBackstageSessionXY('web', 'friendship');
        $friendships = Site_configs::where('name', 'friendship')->orderBy('id', 'desc')->get();
        return view('backstage.friendship', compact('friendships'));
    }

    public function handleFriendShip(Request $request)
    {
        $req = $request->all();
        switch ($req['type'])
        {
            case 'create':
                $data = [
                    'name' => 'friendship',
                    'value' => $req['name'],
                    'value2' => $req['url'],
                    'value3' => $req['priority'],
                ];
                $validate = Validator::make($data, [
                    'value' => 'required|string|max:500',
                    'value2' => 'required|string|max:500',
                    'value3' => 'required|numeric|max:500',
                ]);
                if($validate->fails())
                {
                    return back()->with('message', '检查到某项数据错误或为空！');
                }
                if(Site_configs::create($data))
                {
                    Cache::forever('friendships', $this->getFriendship());
                    return back()->with('message', '创建成功！');
                }
                return back()->with('message', '创建失败！');
            case 'update':
                $data = [
                    'value' => $req['name'],
                    'value2' => $req['url'],
                    'value3' => $req['priority'],
                ];
                $validate = Validator::make($data, [
                    'value' => 'required|string|max:500',
                    'value2' => 'required|string|max:500',
                    'value3' => 'required|numeric|max:500',
                ]);
                if($validate->fails())
                {
                    return back()->with('message', '检查到某项数据错误或为空！');
                }
                if(Site_configs::where('id', $req['id'])->update($data))
                {
                    Cache::forever('friendships', $this->getFriendship());
                    return back()->with('message', '更新成功！');
                }
                return back()->with('message', '更新失败！');
            case 'delete':
                if(Site_configs::find($req['id'])->delete())
                {
                    Cache::forever('friendships', $this->getFriendship());
                    return back()->with('message', '删除成功！');
                }
                return back()->with('message', '删除失败！');
        }

    }

    public function sitePicture()
    {
        session(['bx'=> 'web']);
        session(['by'=> 'sitepicture']);
        Cache::forever('configs', $this->getSiteConfig());

        $configs = Cache::rememberForever('configs', function (){
            return $this->getSiteConfig();
        });

        return view('backstage.sitepicture', compact('configs'));

    }

    public function savePicture(Request $request)
    {
        if ($request->isMethod('post')) {
            $path = '/uploads/'.$request->file('picture')->store('pictures', 'uploads');
            if(Site_configs::where('name', $request->all()['name'])->update(['value' => $path]))
            {
                Cache::forever('configs', $this->getSiteConfig());
                return back()->with('message', '更新成功！');

            }

            return back()->with('message', '更新失败！');
        }
    }

    public function siteCarousel()
    {
        session(['bx'=> 'web']);
        session(['by'=> 'sitecarousel']);
        $configs = Cache::rememberForever('configs', function (){
            return $this->getSiteConfig();
        });
        return view('backstage.sitecarousel', compact('configs'));
    }

    public function saveCarouserl(Request $request)
    {
        if ($request->isMethod('post')) {
            $path = '/uploads/'.$request->file('picture')->store('pictures', 'uploads');
            if($request->all()['type'] == 'create')
            {
                if(Site_configs::create(['name' => $request->all()['name'], 'value' => $path, 'value2' => $request->all()['value2']]))
                {
                    Cache::forever('configs', $this->getSiteConfig());
                    return back()->with('message', '添加成功！');

                }
            }else{
                if(Site_configs::where('id', $request->all()['id'])->update(['value' => $path, 'value2' => $request->all()['value2']]))
                {
                    Cache::forever('configs', $this->getSiteConfig());
                    return back()->with('message', '更新成功！');

                }
            }

            return back()->with('message', '添加失败！');
        }
    }

    public function saveCarouselUrl(Request $request)
    {
        $req =  $request->all();
        if(Site_configs::where('id', $req['id'])->update(['value2' => $req['url']]))
        {
            Cache::forever('configs', $this->getSiteConfig());
            return response()->json([
                'code' => 1,
                'msg' => '更新成功！',
                'url' => $req['url'],
            ]);
        }
        return response()->json([
            'code' => 0,
            'msg' => '更新失败！',
            'url' => $req['url'],
        ]);
    }

    public function deleteCarousel($id)
    {
        if(Site_configs::find($id)->delete())
        {
            Cache::forever('configs', $this->getSiteConfig());
            return response()->json([
                'code' => 1,
                'msg' => '删除成功！',
            ]);
        }
        return response()->json([
            'code' => 0,
            'msg' => '删除失败！',
        ]);
    }

    public function siteNavigation()
    {

        Cache::forever('navigations', $this->getSiteNavigation());

        $navigations = Cache::rememberForever('navigations', function (){
            return $this->getSiteNavigation();
        });
        session(['bx'=> 'web']);
        session(['by'=> 'sitenavigation']);
//        $navigations = Site_navigations::where([])->orderBy('priority')->get();
        return view('backstage.sitenavigation',compact('navigations'));
    }

    public function saveNavigation(Request $request)
    {

        $req = $request->all();
        $validate = Validator::make($req, [
            'type' => 'required|string|max:500',
            'id' => 'required|string|max:500',
            'name' => 'required|string|max:500',
            'url' => 'required|string|max:500',
            'priority' => 'required|numeric',
        ]);
        if($validate->fails()){
            return back()->with('message', '数据有误，操作失败！');
        }

        switch ($req['type'])
        {
            case 'create':
                if($req['id'] == 'f')
                {
                    $file = $request->file('picture');
                    if($file)
                    {
                        $path = '/uploads/'.$file->store('pictures', 'uploads');

                        if(Site_navigations::create(['name' => $req['name'], 'fid' => 0, 'url' => $req['url'], 'picture_url' => $path, 'priority' => $req['priority']]))
                        {
                            Cache::forever('navigations', $this->getSiteNavigation());
                            Cache::forever('bottomlist', $this->getBottomList());

                            return back()->with('message', '添加成功！');
                        }
                    }
                }else{
                    if(Site_navigations::create(['name' => $req['name'], 'fid' => $req['id'], 'url' => $req['url'], 'priority' => $req['priority']]))
                    {
                        Cache::forever('navigations', $this->getSiteNavigation());
                        Cache::forever('bottomlist', $this->getBottomList());

                        return back()->with('message', '添加成功！');
                    }
                }
                return back()->with('message', '创建失败！');
            case 'update':
                if(Site_navigations::where('id', $req['id'])->update(['name' => $req['name'], 'url' => $req['url'], 'priority' => $req['priority']]))
                {
                    Cache::forever('navigations', $this->getSiteNavigation());
                    Cache::forever('bottomlist', $this->getBottomList());
                    return back()->with('message', '更改成功！');
                }
                return back()->with('message', '更改失败！');
            case 'updatepicture':
                $file = $request->file('picture');
                if($file)
                {
                    $path = '/uploads/'.$file->store('pictures', 'uploads');
                    if(Site_navigations::find($req['id'])->update(['name' => $req['name'], 'url' => $req['url'], 'picture_url' => $path]))
                    {
                        Cache::forever('navigations', $this->getSiteNavigation());
                        Cache::forever('bottomlist', $this->getBottomList());

                        return back()->with('message', '更新成功！');
                    }
                    return back()->with('message', '更新失败！');
                }
                return back()->with('message', '图片上传失败！');
            case 'delete':
                if(Site_navigations::where('fid', $req['id'])->count())
                {
                    return back()->with('message', '删除失败，还存在二级导航！');
                }
                if(Site_navigations::find($req['id'])->delete())
                {
                    Cache::forever('navigations', $this->getSiteNavigation());
                    Cache::forever('bottomlist', $this->getBottomList());
                    return back()->with('message', '删除成功！');
                }
                return back()->with('message', '删除失败！');

        }

        return back()->with('message', '操作失败！');

    }

    public function editNavigation($id)
    {
        $navigation = Site_navigations::find($id);
        return view('backstage.editnavigation', compact('navigation'));
    }

    public function updateNavigation(Request $request)
    {
        $req = $request->all();
        $validate = Validator::make($req, [
            'id' => 'required|numeric',
            'fid' => 'required|numeric',
            'name' => 'required|string|max:500',
            'url' => 'required|string|max:500',
            'priority' => 'required|numeric',
            'content' => 'required|string',
        ]);
        if($validate->fails()){
            return back()->with('message', '数据有误，操作失败！');
        }
        if($req['fid'] == 0)
        {
            if(Site_navigations::where('id', $req['id'])->update(['name' => $req['name'], 'url' => $req['url'], 'priority' => $req['priority'], 'picture_url' => $req['picture_url'], 'content' => $req['content']]))
            {
                Cache::forever('navigations', $this->getSiteNavigation());
                Cache::forever('bottomlist', $this->getBottomList());

                return back()->with('message', '更新成功！');
            }
            return back()->with('message', '更新失败！');
        }else{
            if(Site_navigations::where('id', $req['id'])->update(['name' => $req['name'], 'url' => $req['url'], 'priority' => $req['priority'], 'content' => $req['content']]))
            {
                Cache::forever('navigations', $this->getSiteNavigation());
                Cache::forever('bottomlist', $this->getBottomList());

                return back()->with('message', '更新成功！');
            }
            return back()->with('message', '更新失败！');
        }

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:500',
            'keywords' => 'required|string|max:500',
            'description' => 'required|string|max:500',
            'welcome' => 'required|string|max:100',
            'weibo' => 'required|string|max:500',
            'copyright' => 'required|string|max:500',
            'address' => 'required|string|max:500',
            'email' => 'required|string|max:500',
            'contact_title' => 'required|string|max:500',
        ]);
    }

    protected function save($request)
    {
        $data = $request->all();
        unset($data['_token']);
        foreach ( $data as $name =>$value){
            Site_configs::where('name', $name)->update(['value' =>$value]);
        }

        Cache::forever('configs', $this->getSiteConfig());
        return true;
    }

}
