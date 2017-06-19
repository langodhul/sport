<?php

namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request;
use App\News;
use App\Site_configs;
use Illuminate\Support\Facades\Cache;

class NewController extends Controller
{
    public function newForm()
    {
        session(['bx'=> 'new']);
        session(['by'=> 'createnew']);

        return view('backstage.createnew');
    }

    public function newList()
    {
        session(['bx'=> 'new']);
        session(['by'=> 'newlist']);
        $news = Cache::rememberForever('news', function (){
           return $this->getNew();
        });
        return view('backstage.newlist', compact('news'));
    }

    public function config()
    {
        session(['bx'=> 'new']);
        session(['by'=> 'newconfig']);

        $configs = Cache::rememberForever('configs', function (){
            return $this->getSiteConfig();
        });
        return view('backstage.newconfig', compact('configs'));
    }

    public function saveFile(Request $request)
    {
        $path = '/uploads/'.$request->file('file')->store('pictures', 'uploads');
        if(Site_configs::where('name', $request->all()['name'])->update(['value' => $path]))
        {
            Cache::forever('configs', $this->getSiteConfig());
            return back()->with('message', '更新成功！');

        }

        return back()->with('message', '更新失败！');
    }

    public function editForm($id)
    {
        $new = News::find($id);

        return view('backstage.editnew', compact('new'));
    }

    public function createNew(Request $request)
    {
        $req = $request->all();
        $data = [
            'title' => $req['title'],
            'creator' => $req['creator'],
            'content' => $req['content'],
            'describe' => $req['describe'],
        ];
        if(News::create($data))
        {
            Cache::forever('news', $this->getNew());
            return back()->with('message', '创建成功！');
        }
        return back()->with('message', '创建失败！');
    }

    public function edit(Request $request)
    {
        $req = $request->all();
        $data = [
            'title' => $req['title'],
            'creator' => $req['creator'],
            'content' => $req['content'],
            'describe' => $req['describe'],
        ];
        if(News::where('id', $req['id'])->update($data))
        {
            Cache::forever('news', $this->getNew());
            return redirect('/backstage/newlist')->with('message', '更新成功！');
        }
        return redirect('/backstage/newlist')->with('message', '更新失败！');
    }

    public function delete($id)
    {
        if(News::find($id)->delete())
        {
            Cache::forever('news', $this->getNew());
            return back()->with('message', '删除成功！');
        }
        return back()->with('message', '删除失败！');
    }

    public function status($id)
    {
        $new = News::find($id);
        if($new->is_show)
        {
            if(News::where('id', $id)->update(['is_show' => 0]))
            {
                Cache::forever('news', $this->getNew());
                return back()->with('message', '所选新闻已隐藏！');
            }
        }else{
            if(News::where('id', $id)->update(['is_show' => 1]))
            {
                Cache::forever('news', $this->getNew());
                return back()->with('message', '所选新闻已显示！');
            }
        }
        return back()->with('message', '删除失败！');
    }

    protected function getNew()
    {
        $news = [];
        foreach (News::where([])->orderBy('id', 'desc')->get() as $new)
        {
            $news[$new->id]['id'] = $new->id;
            $news[$new->id]['title'] = $new->title;
            $news[$new->id]['creator'] = $new->creator;
            $news[$new->id]['content'] = $new->content;
            $news[$new->id]['is_show'] = $new->is_show;
            $news[$new->id]['describe'] = $new->describe;
            $news[$new->id]['updated_at'] = $new->updated_at;
            $news[$new->id]['year_month'] = mb_substr($new->updated_at, 0, 7);
            $news[$new->id]['day'] = mb_substr($new->updated_at, 8, 2);
        }
        return $news;
    }

    protected function getSiteConfig()
    {
        $configs = [];
        $num = 0;
        foreach (Site_configs::all() as $config)
        {
            if($config->name == 'carousel')
            {
                $configs[$config->name][$num]['id'] = $config->id;
                $configs[$config->name][$num]['path'] = $config->value;
                $configs[$config->name][$num]['url'] = $config->value2;
                $num ++;
            }else{
                $configs[$config->name] = $config->value;
            }
        }

        return $configs;
    }
}
